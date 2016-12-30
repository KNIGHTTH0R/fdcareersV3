/**
 * Export the root Spark application.
 */
module.exports = {
    el: '#spark-app',


    /**
     * Holds the timestamp for the last time we updated the API token.
     */
    lastRefreshedApiTokenAt: null,


    /**
     * The application's data.
     */
    data: {
        user: Spark.state.user,
        teams: Spark.state.teams,
        currentTeam: Spark.state.currentTeam,

        loadingNotifications: false,
        notifications: null,

        supportForm: new SparkForm({
            from: '',
            subject: '',
            message: ''
        })
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        if (Spark.userId) {
            this.loadDataForAuthenticatedUser();
        }

        if (Spark.userId && Spark.usesApi) {
            this.refreshApiTokenEveryFewMinutes();
        }

        Bus.$on('updateUser', function () {
            self.getUser();
        });

        Bus.$on('updateTeams', function () {
            self.getTeams();
        });

        Bus.$on('showNotifications', function () {
            $('#modal-notifications').modal('show');

            self.markNotificationsAsRead();
        });

        Bus.$on('showSupportForm', function () {
            if (self.user) {
                self.supportForm.from = self.user.email;
            }

            $('#modal-support').modal('show');

            setTimeout(() => {
                $('#support-subject').focus();
            }, 500);
        });
    },


    /**
     * Prepare the application.
     */
    mounted() {
        this.whenReady();
    },


    methods: {
        /**
         * Finish bootstrapping the application.
         */
        whenReady() {
            //
        },


        /**
         * Load the data for an authenticated user.
         */
        loadDataForAuthenticatedUser() {
            this.getNotifications();
        },


        /**
         * Refresh the current API token every few minutes.
         */
        refreshApiTokenEveryFewMinutes() {
            this.lastRefreshedApiTokenAt = moment();

            setInterval(() => {
                this.refreshApiToken();
            }, 240000);

            setInterval(() => {
                if (this.lastRefreshedApiTokenAt.diff(moment(), 'minutes') >= 5) {
                    this.refreshApiToken();
                }
            }, 5000);
        },


        /**
         * Refresh the current API token.
         */
        refreshApiToken() {
            this.lastRefreshedApiTokenAt = moment();

            this.$http.put('/spark/token');
        },


        /*
         * Get the current user of the application.
         */
        getUser() {
            this.$http.get('/user/current')
                .then(response => {
                    this.user = response.data;

                    ga('set', 'userId', this.user.id);
                    
                    woopra.identify({
                        email: this.user.email,
                        name: this.user.first_name + ' ' + this.user.last_name,
                    });

                    // The identify code should be added before the "track()" function
                    woopra.track();
                });
        },


        /**
         * Get the current team list.
         */
        getTeams() {
            this.$http.get('/'+Spark.pluralTeamString)
                .then(response => {
                    this.teams = response.data;
                });
        },


        /**
         * Get the current team.
         */
        getCurrentTeam() {
            this.$http.get(`/${Spark.pluralTeamString}/current`)
                .then(response => {
                    this.currentTeam = response.data;
                })
                .catch(response => {
                    //
                });
        },


        /**
         * Get the application notifications.
         */
        getNotifications() {
            this.loadingNotifications = true;

            this.$http.get('/notifications/recent')
                .then(response => {
                    this.notifications = response.data;

                    this.loadingNotifications = false;
                });
        },


        /**
         * Mark the current notifications as read.
         */
        markNotificationsAsRead() {
            if ( ! this.hasUnreadNotifications) {
                return;
            }

            this.$http.put('/notifications/read', {
                notifications: _.pluck(this.notifications.notifications, 'id')
            });

            _.each(this.notifications.notifications, notification => {
                notification.read = 1;
            });
        },


        /**
         * Send a customer support request.
         */
        sendSupportRequest() {
            Spark.post('/support/email', this.supportForm)
                .then(() => {
                    $('#modal-support').modal('hide');

                    this.showSupportRequestSuccessMessage();

                    this.supportForm.subject = '';
                    this.supportForm.message = '';
                });
        },


        /**
         * Show an alert informing the user their support request was sent.
         */
        showSupportRequestSuccessMessage() {
            swal({
                title: 'Got It!',
                text: 'We have received your message and will respond soon!',
                type: 'success',
                showConfirmButton: false,
                timer: 2000
            });
        }
    },


    computed: {
        /**
         * Determine if the user has any unread notifications.
         */
        hasUnreadAnnouncements() {
            if (this.notifications && this.user) {
                if (this.notifications.announcements.length && ! this.user.last_read_announcements_at) {
                    return true;
                }

                return _.filter(this.notifications.announcements, announcement => {
                    return moment.utc(this.user.last_read_announcements_at).isBefore(
                        moment.utc(announcement.created_at)
                    );
                }).length > 0;
            }

            return false;
        },


        /**
         * Determine if the user has any unread notifications.
         */
        hasUnreadNotifications() {
            if (this.notifications) {
                return _.filter(this.notifications.notifications, notification => {
                    return ! notification.read;
                }).length > 0;
            }

            return false;
        }
    }
};

<spark-update-contact-information :user="user" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">Contact Information</div>

        <div class="panel-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your contact information has been updated!
            </div>

            <form class="form-horizontal" role="form">
                <!-- First Name -->
                <div class="form-group" :class="{'has-error': form.errors.has('first_name')}">
                    <label class="col-md-4 control-label">First Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="first_name" v-model="form.first_name">

                        <span class="help-block" v-show="form.errors.has('first_name')">
                            @{{ form.errors.get('first_name') }}
                        </span>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="form-group" :class="{'has-error': form.errors.has('last_name')}">
                    <label class="col-md-4 control-label">Last Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="last_name" v-model="form.last_name">

                        <span class="help-block" v-show="form.errors.has('last_name')">
                            @{{ form.errors.get('last_name') }}
                        </span>
                    </div>
                </div>

                <!-- E-Mail Address -->
                <div class="form-group" :class="{'has-error': form.errors.has('email')}">
                    <label class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" v-model="form.email">

                        <span class="help-block" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-contact-information>

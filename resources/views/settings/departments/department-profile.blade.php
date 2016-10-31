<department-profile inline-template>
    <div>
        <div class="row" v-if="loading">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="fa fa-btn fa-spinner fa-spin"></i>Loading
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if=" ! loading && error">
            <div class="panel panel-default" v-if="error">
                <div class="panel-heading">
                    <i class="fa fa-btn fa-times" style="cursor: pointer;" @click="showSearch()"></i>
                    Error
                </div>

                <div class="panel-body">
                    <strong>@{{ error }}</strong>
                </div>
            </div>
        </div>

        <div v-if=" ! loading && department">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-flush">
                        <!-- Create Button -->
                        <button type="submit" class="btn btn-primary btn-block" @click="addPosition()">
                            <i class="fa fa-plus"></i> Add Position
                        </button>
                    </div>

                    <div class="panel panel-default" v-if="department">
                        <div class="panel-heading">
                            <i class="fa fa-btn fa-times" style="cursor: pointer;" @click="showSearch()"></i>
                            Department Positions
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="positions list-group-item" v-for="position in positions" @click="showPosition(position)">
                                    @{{ position.title }} (@{{ position.position_type | capitalize }})
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Update Department Photo -->
                    @include('settings.departments.profile.update-department-profile-photo')

                    <!-- Update Department Information -->
                    @include('settings.departments.profile.update-department-info')
                </div>
            </div>
        </div>

        <div>
            @include('settings.positions.modals.add-position')
        </div>
    </div>
</department-profile>
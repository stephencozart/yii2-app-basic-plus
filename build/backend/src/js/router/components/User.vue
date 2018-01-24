<template>
    <div class="component user">
        <div class="component-bread-crumbs">
            <router-link to="/users"><font-awesome-icon icon="angle-left"></font-awesome-icon> Users</router-link>
        </div>
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">
                    <font-awesome-icon :icon="icon"></font-awesome-icon>
                    {{ title }}
                </h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">

            </div>
        </header>
        <div class="component-body">
            <form @submit.prevent="validateBeforeSubmit">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="user-first-name">First Name</label>
                                <input autofocus v-validate="'required'" v-model="model.first_name" id="user-first-name" name="first_name" class="form-control" />
                                <div v-show="errors.has('first_name')" class="help-block text-danger">{{ errors.first('first_name') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="user-last-name">Last Name</label>
                                <input v-validate="'required'" v-model="model.last_name" id="user-last-name" name="last_name" class="form-control" />
                                <div v-show="errors.has('last_name')" class="help-block help-block-error">{{ errors.first('last_name') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div :class="{'form-group':true, 'required': true, 'has-error': errors.has('email')}">
                                <label for="user-first-name">Email</label>
                                <input v-validate="'required|email'" v-model="model.email" id="user-email" name="email" class="form-control" />
                                <div v-show="errors.has('email')" class="help-block help-block-error">{{ errors.first('email') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <checkbox id="send-invite-email" v-if="!$route.params.id">
                        <input slot="input" type="checkbox" id="send-invite-email" v-model="model.send_invite" />
                        <span slot="label">Send email invite</span>
                    </checkbox>
                    <button type="submit" :disabled="errors.any()" class="btn btn-primary btn-rounded btn-lg">
                        {{ buttonLabel }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>
<script>
    import Checkbox from "../../components/Checkbox";
    import _ from "lodash";

    export default {
        components: {Checkbox},
        props: [
            'icon'
        ],
        data() {
            return {
                model: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    send_invite: false
                }
            }
        },
        computed: {
            title() {
                return this.$route.name === 'add-user' ? 'Add User' : 'User';
            },
            successMessage() {
                return this.$route.params.id ? 'User has been updated!' : 'User has been created!';
            },
            redirect() {
                return this.$route.params.id ? null : {name: 'edit-user', params: { id: this.model.id } }
            },
            buttonLabel() {
                return this.$route.params.id ? 'Update User' : 'Add User'
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let request;
                        if (this.$route.name === 'add-user') {
                            request = this.$http.post('/admin/users', this.model);
                        } else {
                            request = this.$http.put('/admin/users/'+this.$route.params.id, this.model);
                        }

                        request.then((response) => {
                            this.model = response.data;
                            this.$store.dispatch('pushSuccessNotification', this.successMessage);
                            let redirect = this.redirect;
                            if (redirect) {
                                this.$router.push(redirect);
                            }
                        }).catch((error) => {

                           if (error.response.data) {
                               console.log(error.response.data);
                               _.each(error.response.data, (error) => {
                                   this.errors.add(error.field, error.message);
                               });
                           }
                           this.$store.dispatch('pushErrorNotification', error.response.statusText);

                        });
                    }
                });
            }
        },
        mounted() {
            if (this.$route.params.id) {
                this.$http.get('/admin/users/'+this.$route.params.id).then((response) => {
                    this.model = response.data;
                });
            }
        }
    }
</script>
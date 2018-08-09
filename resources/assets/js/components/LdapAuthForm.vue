<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Test your authentication with LDAP server</div>

                    <div class="card-body" v-if="!authenticated">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="alert alert-danger" v-if="error">
                                    <strong>Oh, no!</strong> {{ error }}
                                </div>
                            </div>
                        </div>
                        <form @submit.prevent="auth" @input="error = null">
                            <div class="form-group row">
                                <label for="server" class="col-sm-4 col-form-label text-md-right">
                                    Server (host)
                                </label>

                                <div class="col-md-6">
                                    <input id="server" type="text" class="form-control" v-model="server" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="port" class="col-sm-4 col-form-label text-md-right">
                                    Port
                                </label>

                                <div class="col-md-6">
                                    <input id="port" type="text" class="form-control" v-model="port" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-sm-4 col-form-label text-md-right">
                                    Email
                                </label>

                                <div class="col-md-6">
                                    <input id="username" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label text-md-right">
                                    Password
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        {{ loading ? 'Checking...' : 'Check' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body" v-if="authenticated">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="alert alert-success">
                                    <strong>Yes!</strong> You are now authenticated. <a href @click.prevent="authenticated = false">(try another credential)</a>
                                </div>
                            </div>

                            <div class="col-md-8 offset-md-2" v-if="user">
                                <dl>
                                    <dt>CN</dt>
                                    <dd>{{ user.cn }}</dd>
                                    <dt>SN</dt>
                                    <dd>{{ user.sn }}</dd>
                                    <dt>Full Name</dt>
                                    <dd>{{ user.fullName}}</dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const STATUSES = {
        LOADING: 'LOADING',
        DONE: 'DONE',
    };

    export default {
        props: ['initialServer', 'initialPort', 'initialEmail'],
        data () {
            return {
                server: this.initialServer,
                port: this.initialPort,
                email: this.initialEmail,
                password: '',
                error: null,
                status: STATUSES.DONE,
                authenticated: false,
                user: null,
            }
        },
        computed: {
            loading () {
                return this.status === STATUSES.LOADING;
            }
        },
        methods: {
            auth () {
                this.status = STATUSES.LOADING;

                axios
                    .post('/ldap/auth', {
                        host: this.server,
                        port: this.port,
                        username: this.email,
                        password: this.password,
                    })
                    .then(({data}) => {
                        this.status = STATUSES.DONE;
                        this.authenticated = true;
                        this.user = data.user;
                    })
                    .catch((error) => {
                        this.status = STATUSES.DONE;
                        this.error = error.response.data.error;
                    });
            }
        }
    }
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="app">
    <div class="contact-buttons">
        <button @click="showContactAddForm">@lang('contact.create')</button>
        <button @click="updateContact">@lang('contact.update')</button>
        <button @click="removeContact">@lang('contact.remove')</button>
    </div>

    <div class="table">
        <div class="table__head">
            <div>@lang('contact.action')</div>
            <div>@lang('contact.number')</div>
            <div>@lang('contact.first_name')</div>
            <div>@lang('contact.last_name')</div>
            <div>@lang('contact.second_name')</div>
            <div>@lang('contact.phone')</div>
            <div>@lang('contact.email')</div>
        </div>

        <div class="table__body">
            <div v-for="contact in contacts">
                <v-contact :data="contact"></v-contact>
            </div>
        </div>
    </div>

    <form class="contact-add-form" action="{{ route('contact.store') }}" method="POST" v-if="contactAddFormShow">
        <fieldset>
            <label for="first_name">@lang('contact.first_name')</label>
            <input name="first_name" v-model="contactAddForm.first_name"/>
        </fieldset>

        <fieldset>
            <label for="second_name">@lang('contact.second_name') *</label>
            <input name="second_name" v-model="contactAddForm.second_name"/>
        </fieldset>

        <fieldset>
            <label for="last_name">@lang('contact.last_name')</label>
            <input name="last_name" v-model="contactAddForm.last_name"/>
        </fieldset>

        <fieldset>
            <label for="phone">@lang('contact.phone') *</label>
            <input name="phone" v-model="contactAddForm.phone"/>
        </fieldset>

        <fieldset>
            <label for="email">@lang('contact.email') *</label>
            <input name="email" v-model="contactAddForm.email"/>
        </fieldset>

        <button @click.prevent="addContact">Send</button>
    </form>
</div>

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
    const app = new Vue({
        el: '#app',
        delimiters: ['[[', ']]'],
        data: {
            contactAddFormShow: false,
            chosenContactId: null,
            contacts: JSON.parse('<?= json_encode($contacts) ?>'),
            contactAddForm: {
                first_name: "",
                second_name: "",
                last_name: "",
                phone: "",
                email: "",
            },
            fetchHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        },
        methods: {
            showContactAddForm() {
                this.contactAddFormShow = true
            },

            addContact() {
                fetch('/contact', {
                    method: 'POST',
                    body: JSON.stringify(this.contactAddForm),
                    headers: this.fetchHeaders,
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }

                        throw new Error('Validation error');
                    })
                    .then(contact => {
                        this.contacts.push(contact);
                        this.flushAddContactForm();
                    })
                    .catch(error => {
                        alert(error.message);
                    });
            },

            flushAddContactForm() {
                for (var prop in this.contactAddForm) {
                    this.contactAddForm[prop] = "";
                }
            },

            removeContact() {
                if (!this.chosenContactId) {
                    this.alertContactIsNotChosen();
                }
                else {
                    fetch('/contact/' + this.chosenContactId, {
                        method: 'DELETE',
                        headers: this.fetchHeaders,
                    })
                        .then(response => {
                            delete(this.contacts[this.chosenContactId]);
                        })
                        .catch(alert);
                }
            },

            updateContact() {
                if (!this.chosenContactId) {
                    this.alertContactIsNotChosen();
                }
                else {
                    let curContact = this.contacts[this.chosenContactId];

                    fetch('/contact/' + this.chosenContactId, {
                        method: 'PUT',
                        body: JSON.stringify(curContact),
                        headers: this.fetchHeaders,
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Contact with id ' + this.chosenContactId + ' success updated');
                            }
                            else {
                                throw new Error('Validation error');
                            }
                        })
                        .catch(alert);
                }
            },

            alertContactIsNotChosen() {
                alert('Choose contact in "Action" column');
            },

            setChosenContact(id) {
                this.chosenContactId = id;
            }
        },
        mounted() {
            this.$root.$on('chooseContact', id => this.setChosenContact(id))
        }
    });
</script>

<style scoped>
    .table {
        display: flex;
        flex-direction: column;
        margin: 0 0 40px;
    }

    .table__head {
        display: flex;
        flex-direction: row;
        font-weight: bold;
    }

    .table__head div {
        border: 1px solid #ccc;
        padding: 10px;
        width: 120px;
    }

    .table__body {
        display: flex;
        flex-direction: column;
    }

    .contact-buttons {
        width: 170px;
        border: 1px solid black;
        margin-left: 20px;
        height: 100%;
        position: fixed;
        right: 10px;
    }

    .contact-buttons button {
        display: block;
        width: 150px;
        margin: 10px;
    }

    .contact-add-form {
        width: 300px;
        border: 1px solid black;
    }

    .contact-add-form label {
        width: 150px;
        float: left;
    }

    .contact-add-form fieldset {
        border: none;
    }

    .contact-add-form button {
        width: 100px;
        margin: 10px;
    }
</style>
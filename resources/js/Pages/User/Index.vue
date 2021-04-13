<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Users
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="px-4 py-3 my-3 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md" role="alert" v-if="$page.props.jetstream.flash[0]">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.jetstream.flash[0] }}</p>
                        </div>
                      </div>
                    </div>
                    <button @click="openModal()" class="px-4 py-2 my-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Create New User</button>
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="w-20 px-4 py-2">No.</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Is Admin</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.id">
                                <td class="px-4 py-2 border">{{ row.id }}</td>
                                <td class="px-4 py-2 border">{{ row.name }}</td>
                                <td class="px-4 py-2 border">{{ row.email }}</td>
                                <td class="px-4 py-2 border">{{ row.is_admin }}</td>
                                <td class="flex justify-end px-4 py-2 space-x-2 border">
                                    <button @click="show(row)" class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700">Show</button>
                                    <button @click="edit(row)" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Edit</button>
                                    <button @click="deleteRow(row)" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <div class="">
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block mb-2 text-sm font-bold text-gray-700">Name:</label>
                                      <input type="text" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.name">
                                      <div v-if="$page.errorBags" class="text-red-500">{{ $page.errorBags[0] }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput2" class="block mb-2 text-sm font-bold text-gray-700">Email:</label>
                                      <input type="email" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" placeholder="Enter Email" v-model="form.email">
                                      <div v-if="$page.errorBags" class="text-red-500">{{ $page.errorBags[0] }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput3" class="block mb-2 text-sm font-bold text-gray-700">Password:</label>
                                      <input type="password" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="exampleFormControlInput3" placeholder="Enter Password" v-model="form.password">
                                      <div v-if="$page.errorBags" class="text-red-500">{{ $page.errorBags[0] }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput4" class="block mb-2 text-sm font-bold text-gray-700">Password Confirmation:</label>
                                      <input type="password" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="exampleFormControlInput4" placeholder="Enter Password Confirmation" v-model="form.password_confirmation">
                                      <div v-if="$page.errorBags" class="text-red-500">{{ $page.errorBags[0] }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput5" class="mr-3 text-sm font-bold text-gray-700">Is Admin:</label>
                                      <input type="checkbox" class="border rounded-full shadow appearance-none focus:outline-none focus:shadow-outline" id="exampleFormControlInput5" v-model="form.is_admin">
                                      <div v-if="$page.errorBags" class="text-red-500">{{ $page.errorBags[0] }}</div>
                                  </div>
                            </div>
                          </div>
                          <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto" v-if="viewMode === false">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                                Save
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto" v-if="viewMode === false">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                            <span class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:w-auto">                              
                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                {{ viewMode === true ? 'Close' : 'Cancel' }}
                              </button>
                            </span>
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from './../../Layouts/AppLayout'
    import Welcome from './../../Jetstream/Welcome'
    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: ['data', 'errorBags'],
        data() {
            return {
                editMode: false,
                viewMode: false,
                isOpen: false,
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    is_admin: false,
                },
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
                this.viewMode=false;
            },
            reset: function () {
                this.form = {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    is_admin: false,
                }
            },
            save: function (data) {
                this.$inertia.post('/admin/users', data);
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            show: function (data) {
                this.form = Object.assign({}, data);
                this.viewMode = true;
                this.openModal();
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/admin/users/' + data.id, data);
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/admin/users/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>
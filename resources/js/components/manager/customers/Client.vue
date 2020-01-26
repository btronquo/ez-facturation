<template>
  <section class="content-header">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Customers</h3>
            <div class="card-tools">
              <button class="btn btn-success" @click="newCustomerModal">
                <i class="fas fa-user-plus fa-fw"></i> New Customer
              </button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Name</th>
                  <th>Contact (F.name / L.name)</th>
                  <th>Email</th>
                  <th>Date de création</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="customer in customers.data" :key="customer.id">
                  <td>{{ customer.id }}</td>
                  <td>{{ customer.type_id }}</td>
                  <td>{{ customer.name | capitalize }}</td>
                  <td>{{ customer.contact_lastname | capitalize }} {{ customer.contact_firstname | capitalize }}</td>
                  <td>{{ customer.contact_mail }}</td>
                  <td>{{ customer.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editCustomerModal(customer)">
                      <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" @click="deleteCustomer(customer.id)">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="customers" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <!-- modal -->
      <div
        class="modal fade"
        id="addNew"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNew"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="!editmode" class="modal-title" id="exampleModalLabel">Add Customer</h5>
              <h5 v-show="editmode" class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateCustomer() : createCustomer()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Contact First Name</label>
                  <input
                    v-model="form.contact_firstname"
                    type="text"
                    name="contact_firstname"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('contact_firstname') }"
                  />
                  <has-error :form="form" field="contact_firstname"></has-error>
                </div>

                <div class="form-group">
                  <label>Contact Last Name</label>
                  <input
                    v-model="form.contact_lastname"
                    type="text"
                    name="contact_lastname"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('contact_lastname') }"
                  />
                  <has-error :form="form" field="contact_lastname"></has-error>
                </div>

                <div class="form-group">
                  <label>Contact Mail</label>
                  <input
                    v-model="form.contact_mail"
                    type="text"
                    name="contact_mail"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('contact_mail') }"
                  />
                  <has-error :form="form" field="contact_mail"></has-error>
                </div>

                <div class="form-group">
                  <label>Contact Phone</label>
                  <input
                    v-model="form.contact_phone"
                    type="text"
                    name="contact_phone"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('contact_phone') }"
                  />
                  <has-error :form="form" field="contact_phone"></has-error>
                </div>

                <div class="form-group">
                  <label>Compagny Name</label>
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <label>Compagny IdNumber (Siret)</label>
                  <input
                    v-model="form.compagnyIdNumber"
                    type="text"
                    name="compagnyIdNumber"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('compagnyIdNumber') }"
                  />
                  <has-error :form="form" field="compagnyIdNumber"></has-error>
                </div>

                <div class="form-group">
                  <label>Compagny Type</label>
                  <select
                    name="type_id"
                    v-model="form.type_id"
                    id="type_id"
                    class="form-control"
                    :class="{
                  'is-invalid': form.errors.has('type_id')}"
                  >
                    <option value>Select Compagny Type</option>
                    <option value="1">SAS</option>
                    <option value="2">SARL</option>
                    <option value="3">EURL</option>
                    <option value="4">SA</option>
                    <option value="5">AE</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Address Line 1</label>
                  <input
                    v-model="form.address_line_1"
                    type="text"
                    name="address_line_1"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('address_line_1') }"
                  />
                  <has-error :form="form" field="address_line_1"></has-error>
                </div>

                <div class="form-group">
                  <label>Address Line 2</label>
                  <input
                    v-model="form.address_line_2"
                    type="text"
                    name="address_line_2"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('address_line_2') }"
                  />
                  <has-error :form="form" field="address_line_2"></has-error>
                </div>

                <div class="form-group">
                  <label>Country</label>
                  <input
                    v-model="form.country"
                    type="text"
                    name="country"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('country') }"
                  />
                  <has-error :form="form" field="country"></has-error>
                </div>

                <div class="form-group">
                  <label>City</label>
                  <input
                    v-model="form.city"
                    type="text"
                    name="city"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('city') }"
                  />
                  <has-error :form="form" field="city"></has-error>
                </div>

                <div class="form-group">
                  <label>ZIP</label>
                  <input
                    v-model="form.zip"
                    type="text"
                    name="zip"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('zip') }"
                  />
                  <has-error :form="form" field="zip"></has-error>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                <button v-show="!editmode" type="submit" class="btn btn-success">Save</button>
                <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.modal -->
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      customers: {},
      editmode: false,
      form: new Form({
        id: "",
        address_line_1: "",
        address_line_2: "",
        city: "",
        country: "",
        contact_firstname: "",
        contact_lastname: "",
        contact_mail: "",
        contact_phone: "",
        name: "",
        type_id: "",
        zip: ""
      })
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/customer/?page=" + page).then(response => {
        this.customers = response.data;
      });
    },
    loadCustomers() {
      axios.get("api/customer").then(({ data }) => (this.customers = data));
    },
    createCustomer() {
      this.$Progress.start();
      this.form
        .post("api/customer")
        .then(() => {
          this.$Progress.start();
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "Customer created successfully!"
          });
        })
        .catch(() => {
          this.$Progress.fail();
          toast.fire({
            icon: "error",
            title: "An error occured!"
          });
        });
      Event.$emit("updateListCustomers");
    },
    deleteCustomer(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.form
              .delete("api/customer/" + id)
              .then(() => {
                swal.fire(
                  "Deleted!",
                  "The Customer has been deleted.",
                  "success"
                );
                Event.$emit("updateListCustomers");
              })
              .catch(() => {
                swal.fire("Failed!", "An error occured", "warning");
              });
          }
        });
    },
    updateCustomer() {
      this.$Progress.start();
      this.form
        .put("api/customer/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "Customer updated successfully!"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
          toast.fire({
            icon: "error",
            title: "An error occured!"
          });
        });

      Event.$emit("updateListCustomers");
    },
    newCustomerModal() {
      this.editmode = false;
      this.form.clear();
      this.form.reset();
      $("#addNew").modal("show");
    },
    editCustomerModal(customer) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(customer);
    }
  },
  created() {

    Event.$on("search", () => {
      let query = this.$parent.inputSearch;
      axios.get('api/findCustomer?q=' + query)
      .then((data) => {
        this.customers = data.data
      })
      .catch(() => {
        toast.fire({
            icon: "warning",
            title: "You search has 0 result!"
          });
      })
    });

    this.loadCustomers();
    Event.$on("updateListCustomers", () => {
      this.loadCustomers();
    });
  }
};
</script>

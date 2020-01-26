<template>
  <section class="content-header">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">References</h3>
            <div class="card-tools">
              <button class="btn btn-success" @click="newReferenceModal">
                <i class="fas fa-plus fa-fw"></i> Add Reference
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
                  <th>Description</th>
                  <th>Price</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="reference in references.data" :key="reference.id">
                  <td>{{ reference.id }}</td>
                  <td>{{ reference.type_id }}</td>
                  <td>{{ reference.name | capitalize }}</td>
                  <td>{{ reference.description | truncate(50, '...') }}</td>
                  <td>{{ reference.price }}</td>
                  <td>{{ reference.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editReferenceModal(reference)">
                      <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" @click="deleteReference(reference.id)">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="references" @pagination-change-page="getResults"></pagination>
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
              <h5 v-show="!editmode" class="modal-title" id="exampleModalLabel">Add Reference</h5>
              <h5 v-show="editmode" class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateReference() : createReference()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
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
                  <label>Description</label>
                  <input
                    v-model="form.description"
                    type="text"
                    name="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                  />
                  <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                  <label>Price</label>
                  <input
                    v-model="form.price"
                    type="text"
                    name="price"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('price') }"
                  />
                  <has-error :form="form" field="price"></has-error>
                </div>

                <div class="form-group">
                  <label>Category</label>
                  <select
                    name="type_id"
                    v-model="form.type_id"
                    id="type_id"
                    class="form-control"
                    :class="{
                  'is-invalid': form.errors.has('type_id')}"
                  >
                    <option value>Select Compagny Type</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
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
      references: {},
      editmode: false,
      form: new Form({
        id: "",
        name: "",
        description: "",
        price: "",
        type_id: ""
      })
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/reference/?page=" + page).then(response => {
        this.references = response.data;
      });
    },
    loadReferences() {
      axios.get("api/reference").then(({ data }) => (this.references = data));
    },
    createReference() {
      this.$Progress.start();
      this.form
        .post("api/reference")
        .then(() => {
          this.$Progress.start();
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "Reference created successfully!"
          });
        })
        .catch(() => {
          this.$Progress.fail();
          toast.fire({
            icon: "error",
            title: "An error occured!"
          });
        });
      Event.$emit("updateListReferences");
    },
    deleteReference(id) {
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
              .delete("api/reference/" + id)
              .then(() => {
                swal.fire(
                  "Deleted!",
                  "The Reference has been deleted.",
                  "success"
                );
                Event.$emit("updateListReferences");
              })
              .catch(() => {
                swal.fire("Failed!", "An error occured", "warning");
              });
          }
        });
    },
    updateReference() {
      this.$Progress.start();
      this.form
        .put("api/reference/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "Reference updated successfully!"
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

      Event.$emit("updateListReferences");
    },
    newReferenceModal() {
      this.editmode = false;
      this.form.clear();
      this.form.reset();
      $("#addNew").modal("show");
    },
    editReferenceModal(reference) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(reference);
    }
  },
  created() {
    Event.$on("search", () => {
      let query = this.$parent.inputSearch;
      axios
        .get("api/findReference?q=" + query)
        .then(data => {
          this.references = data.data;
        })
        .catch(() => {
          toast.fire({
            icon: "warning",
            title: "You search has 0 result!"
          });
        });
    });

    this.loadReferences();
    Event.$on("updateListReferences", () => {
      this.loadReferences();
    });
  }
};
</script>

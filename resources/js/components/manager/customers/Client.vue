<template>
  <section class="content-header">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Customers</h3>
            <div class="card-tools">
              <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
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
                  <th>Contact (Fname / Lname)</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>2</td>
                  <td>LTD</td>
                  <td>Access Print</td>
                  <td>John Doe</td>
                  <td>jdoe@jdoe.com</td>
                  <td>
                    <a href="#">
                      <i class="fa fa-edit"></i>
                    </a>

                    <a href="#">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
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
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
        <!-- /.modal -->
      </div>
    </div>
  </section>
</template>

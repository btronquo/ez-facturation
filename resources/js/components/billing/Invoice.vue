<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Billing</h1>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <!-- INVOICE GENERATOR -->
        <div class="card card-default color-palette-box">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-file-invoice"></i>
              New Invoice
            </h3>
          </div>
          <div v-show="showInvoiceForm" class="card-body">
            <div class="row">
              <div class="col-md-12">
                <!-- form invoice -->
                <form @submit.prevent>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="customer">For Customer</label>
                        <select v-model="customer" class="form-control" id="customer">
                          <option disabled value selected="selected">Please select one</option>
                          <option
                            v-for="customer in customers.data"
                            :key="customer.id"
                            v-bind:value="customer.id"
                          >{{customer.name}}</option>
                        </select>
                      </div>
                    </div>
                    <!-- select customer -->
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <!-- select reference -->
                      <div class="form-group">
                        <select v-model="reference" class="form-control" id="reference">
                          <option disabled value selected="selected">Select Reference</option>
                          <option
                            v-for="reference in references.data"
                            :key="reference.id"
                            v-bind:value="reference"
                          >{{ reference.name }} - {{ reference.price }}€</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="number" v-model="quantity" class="form-control" />
                        <small
                          id="passwordHelpBlock"
                          class="form-text text-muted"
                        >Enter the quantity here (default: 1)</small>
                      </div>
                    </div>
                    <div class="col-md-2">
                        <button
                          type="submit"
                          @click="addToInvoice"
                          class="btn btn-primary mb-2 float-left"
                          :disabled=isDisabledReferenceBtn
                        >Add Reference</button>
                      </div>
                  </div>
                </form>
                <!-- /.form invoice -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div v-show="invoiceTotal" class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>id ref</th>
                      <th>Name</th>
                      <th>Unit Price</th>
                      <th>Quantity</th>
                      <th>SubTotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="invoiceref in invoice" :key="invoiceref.id">
                      <td>{{ invoiceref.id }}</td>
                      <td>{{ invoiceref.name }}</td>
                      <td>{{ invoiceref.price }} €</td>
                      <td>{{ invoiceref.quantity }}</td>
                      <td>{{ invoiceref.subtotal }}</td>
                    </tr>
                  </tbody>
                </table>
                <h3>
                  TOTAL:
                  <strong>{{ invoiceTotal }} €</strong>
                </h3>
              </div>
              <!-- /.col -->
            </div>
          </div>

          <div v-show="showSavedConfig" class="card-body">
            <p>Invoice Saved!</p>
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <button
              type="button"
              class="btn btn-theme btn-info float-right"
              @click="saveBill"
              :disabled=isDisabled
            >
              <i class="fas fa-cogs"></i> Generate Bill
            </button>
            <p>customer id: {{ customer }}</p>
            <p>invoice total: {{ invoiceTotal }}</p>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showInvoiceForm: true,
      createdBillId: null,
      showSavedConfig: false,
      quantity: 1,
      invoiceGlobal: "",
      invoiceCustomer: "",
      invoice: [],
      invoiceref: "",
      invoiceTotal: false,
      customers: {},
      customer: "",
      references: {},
      billId: "",
      reference: "",
      editmode: false,
      form: new Form({
        id: "",
        billing_date: "",
        customer_id: "",
        status_id: "",
        amount: "",
        comment: ""
      })
    };
  },
  methods: {
    saveBill(){

      this.showInvoiceForm = !this.showInvoiceForm;
      this.showSavedConfig = !this.showInvoiceForm;

      this.invoiceGlobal = {
        ...this.invoiceGlobal,
        customerId: this.customer,
        references: this.invoice,
        totalPrice: this.invoiceTotal
      };

      this.form.customer_id = this.customer;
      this.form.status_id = 2;
      this.form.amount = this.invoiceTotal;
      this.form.billing_date = new Date().toISOString().slice(0, 19).replace('T', ' ');
      this.form.comment = "youpi";

      this.form
      .post("api/billing")
      .then((response) => {
        this.createdBillId = response.data
        this.$Progress.start();
        $("#addNew").modal("hide");
        toast.fire({
          icon: "success",
          title: "Billing saved -> ID = " + this.createdBillId + "!"
        });
        // ajouter this.createdBillId à this.invoiceGlobal
        this.invoiceGlobal = {
          ...this.invoiceGlobal,
          billId: this.createdBillId
        };
      })
      .then(() => {
        console.log('aoaoaoaoaoao: ', this.invoiceGlobal)
        axios.post("api/billingdetail", { data: this.invoiceGlobal })
        .then(({ data }) => (this.customers = data));
      })
      .then(() => {
          this.$router.push({ name: 'invoice-result', params: { invoice: this.createdBillId }}) // -> /user/123
      })
      .catch((error) => {
        console.error(error)
        this.$Progress.fail();
        toast.fire({
          icon: "error",
          title: "An error occured!"
        });
      });

    },
    loadCustomers() {
      axios.get("api/customer").then(({ data }) => (this.customers = data));
    },
    loadReferences() {
      axios.get("api/reference").then(({ data }) => (this.references = data));
    },
    addToInvoice() {
      const subtotal = this.reference.price * this.quantity;

      this.reference = {
        ...this.reference,
        subtotal: subtotal,
        quantity: this.quantity
      };
      // on vas aussi poussier un nouvel objet
      this.invoice.push(this.reference);
      this.invoiceTotal += this.reference.price * this.quantity;
      this.reference = ""
    }
  },
  created() {
    this.loadCustomers();
    this.loadReferences();
  },
  computed: {
    isDisabled() {
    // test if button form should be disabled or not
      if (!this.customer & !this.invoiceref) {
        return true;
      }
    },
    isDisabledReferenceBtn() {
      if(!this.reference) {
        return true;
      }
    }
  }
};
</script>

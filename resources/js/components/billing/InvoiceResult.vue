<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice ID: {{ $route.params.invoice }}</h1>
            <p>Date: 20-01-2018</p>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info no-print">
              <h5>
                <i class="fas fa-info"></i> Note:
              </h5>This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="/img/logo_compagny.png" class="img-fluid w-25" alt />
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 align="center">
                    <strong>INVOICE N°XXXXX</strong>
                  </h3>
                </div>
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Seller
                  <address>
                    <strong>CompagnyName - John Doe</strong>
                    <br />Rue des mimosats
                    <br />Oasis, 34879
                    <br />Phone: (+33) 6 00 00 00 00
                    <br />Email: jdoe@example.com
                  </address>
                </div>
                <div class="col-sm-4 invoice-col"></div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Customer
                  <address>
                    <strong>{{ invoice ? invoice.customer.name : 'Compagny Name' }}</strong>
                    <br />
                    {{ invoice ? invoice.customer.address_line_1 : 'Address Line 1' }}
                    <br />
                    {{ invoice ? invoice.customer.address_line_2 : 'Address Line 2' }}
                    <br />
                    {{ invoice ? invoice.customer.zip : '73000' }} - {{ invoice ? invoice.customer.city : 'CHAMBERY' }} - {{ invoice ? invoice.customer.country : 'FRANCE' }}
                    <br />
                    VAT ID NUMBER: {{ invoice ? invoice.customer.name : 'XXXXXXX' }}
                  </address>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>REF</th>
                        <th>DESCRIPTION</th>
                        <th>QUANTITY</th>
                        <th>UNIT PRICE</th>
                        <th>SUB TOTAL (HT)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="reference in invoice['billdetail']" :key="reference.id">
                        <td>{{ reference.reference_id }}</td>
                        <td>{{ reference.comment }}</td>
                        <td>{{ reference.quantity }}</td>
                        <td>{{ reference.unit_price}}</td>
                        <td>{{ reference.unit_price * reference.quantity}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- payment terms -->
                <div class="col-6">
                  <p class="lead">Payment Terms:</p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th>Total HT:</th>
                          <td>{{ invoice.amount }} €</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                  <p class="text-muted well well-sm shadow-none float-right">Legal text here</p>
                </div>
              </div>
              <!-- ./row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a @click="print" href="#" class="btn btn-default">
                    <i class="fas fa-print"></i> Print
                  </a>

                  <button type="button" class="btn btn-success float-right">
                    <i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button
                    type="button"
                    class="btn btn-primary float-right"
                    style="margin-right: 5px;"
                  >
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      invoice: ""
    };
  },
  methods: {
    print() {
      window.print();
    },
    loadInvoice(id) {
      axios
        .get("api/billing/" + id)
        .then(({ data }) => (this.invoice = data["0"]))
        .then(() => {
          console.log("resultat loadinvoice: ", this.invoice);
        });
    }
  },
  beforeMount() {
    this.loadInvoice(this.$route.params.invoice);
  }
};
</script>

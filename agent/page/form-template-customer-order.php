<div class="row row-same-height">
  <div class="col-md-4 b-r b-dashed b-grey sm-b-b">
    <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-20">
      <!-- <i class="fa fa-user fa-2x hint-text"></i> -->
      <!-- <h2 class="bold m-b-0 p-b-0">Pesanan Stok</h2> -->
      <h3 class="font-montserrat text-uppercase"> Pesanan Stok</h3>
      <p>Sila pastikan maklumat yang dimasukkan adalah betul. Pilih stokis, tarikh pesanan, tarikh pungutan dan kuantiti produk yang hendak dipesan oleh stokis</p>
      <p class="small hint-text">Ruangann yang bertanda (<span class="text-danger">*</span>) adalah butiran mandatori perlu diisi.</p>
    </div>
  </div>
  <div class="col-md-8">

    <div class="padding-30 sm-padding-5">
      <form id="form-stokist-order" name="form-stokist-order" class="m-t-25 m-b-20">
        <div class="row m-b-20">
          <div class="col-md-12">
            <button id="back" type="button" class="btn btn-primary" name="button"> <i class="fa fa-arrow-left m-r-10"></i> Kembali</button>
          </div>
        </div>

        <div class="row m-t-5">
          <div class="col-md-6">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Nama Penuh</label>
              <input required id="fullname" name="fullname" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">No. Telefon</label>
              <input required id="phone" name="phone" type="text" class="form-control" placeholder="">
            </div>
          </div>
        </div>
        <div class="row m-t-5">
          <div class="col-md-12">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Alamat Penerima</label>
              <textarea style="height:100px" required id="address" name="address" type="text" class="form-control" placeholder="" >
              </textarea>
            </div>
          </div>
        </div>

        <h5 class="text-black block-title font-montserrat text-uppercase bold small">Senarai Produk</h5>
        <div class="col-md-12 no-padding">
          <table class="table table-condensed" id="table-product">
            <thead>
              <tr>
                <th style="width:200px;padding-left:0px;" class="text-left no-padding hidden">#</th>
                <th style="padding-left:0px;" class="text-left no-padding">Nama Produk</th>
                <th style="width:100px;" class="text-center">Kuantiti</th>
                <th style="width:120px;" class="text-center hidden-xs">Asal</th>
                <th style="width:120px;" class="text-center">Dropship</th>
              </tr>
            </thead>
            <tbody>
              <?php getProductCustomer(); ?>
            </tbody>
          </table>
        </div>

        <h5 class="text-black block-title m-t-20 m-b-20 font-montserrat text-uppercase bold small">Delivery Information</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Jenis Penghantaran</label>
              <select required data-init-plugin='select2' id="JenisPenghantaran" name="JenisPenghantaran" class="form-control full-width" >
                <?php getJenisPenghantaran(); ?>
              </select>
              <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
            </div>
          </div>
        </div>


        <div class="row m-t-10">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary" name="button">Order & Pay <i class="fa fa-send m-l-5"></i></button>
          </div>
        </div>

        <div class="m-t-30" id="cetakDokumenDiv" style="display:none;">
          <h5 class="text-black block-title m-t-10 m-b-20 font-montserrat text-uppercase bold small">Cetak Dokumen</h5>

          <div class="row m-t-20">
            <div class="col-md-12">
              <button type="button" class="btn btn-success" id="PrintStockOrder">Stock Order <i class="fa fa-print m-l-5"></i></button>
              <button type="button" class="btn btn-success" id="PrintInvoice">Invoice <i class="fa fa-print m-l-5"></i></button>
              <button type="button" class="btn btn-success" id="PrintReceipt">Receipt <i class="fa fa-print m-l-5"></i></button>
              <button type="button" class="btn btn-success" id="PrintDeliveryOrder">Delivery Order <i class="fa fa-print m-l-5"></i></button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<div class="row row-same-height">
  <div class="col-md-4 b-r b-dashed b-grey sm-b-b">
    <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-20">
      <!-- <i class="fa fa-user fa-2x hint-text"></i> -->
      <!-- <h2 class="bold m-b-0 p-b-0">Pesanan Stok</h2> -->
      <h3 class="font-montserrat text-uppercase"> Stock Record</h3>
      <p>Sila pastikan maklumat yang dimasukkan adalah betul. Pilih produk dan kuantiti produk yang akan dimasukkan kedalam stok.</p>
      <p class="small hint-text">Ruangann yang bertanda (<span class="text-danger">*</span>) adalah butiran mandatori perlu diisi.</p>
    </div>
  </div>
  <div class="col-md-8">

    <div class="padding-30 sm-padding-5">
      <form id="form-stock-record" name="form-stock-record" class="m-t-25 m-b-20">
        <div class="row m-b-20">
          <div class="col-md-12">
            <button id="back" type="button" class="btn btn-primary" name="button"> <i class="fa fa-arrow-left m-r-10"></i> Kembali</button>
          </div>
        </div>

        <div class="row m-t-5">
          <div class="col-md-8">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Product</label>
              <select required data-init-plugin='select2' id="product" name="product" class="form-control full-width" >
                <?php getProductSelect(); ?>
              </select>
              <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Quantity</label>
              <input required id="quantity" name="quantity" type="number" min="1" class="form-control" placeholder="">
            </div>
          </div>
        </div>

        <!-- <h5 class="text-black block-title m-t-10 m-b-20 font-montserrat text-uppercase bold small">Delivery Method</h5> -->

        <div class="row m-t-20">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary" name="button">Save <i class="fa fa-send m-l-5"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

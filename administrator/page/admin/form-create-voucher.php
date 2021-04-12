<div class="row row-same-height">
  <div class="col-md-4 b-r b-dashed b-grey sm-b-b">
    <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-20">
      <!-- <i class="fa fa-user fa-2x hint-text"></i> -->
      <!-- <h2 class="bold m-b-0 p-b-0">Maklumat Stokis</h2> -->
      <h3 class="font-montserrat text-uppercase"> Tambah Voucher</h3>
      <p>Sila Masukkan Maklumat Voucher yang betul</p>
      <p class="small hint-text">Ruangann yang bertanda (<span class="text-danger">*</span>) adalah butiran mandatori perlu diisi.</p>
    </div>
  </div>
  <div class="col-md-8">

    <div class="padding-30 sm-padding-5">
      <form id="form-stokist" name="form-stokist" class="m-t-25 m-b-20">
        <div class="row m-b-20">
          <div class="col-md-12">
            <button id="back" type="button" class="btn btn-primary" name="button"> <i class="fa fa-arrow-left m-r-10"></i> Kembali</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 ">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Voucher</label>
              <select required data-init-plugin='select2' id="voucher" name="voucher" class="form-control full-width" >
                <?php getVoucher(); ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Bil Voucher</label>
              <input required id="bilvoucher" name="bilvoucher" type="number" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">No. Telefon Pelanggan</label>
              <input required id="customerNoPhone" name="customerNoPhone" type="text" value="+601" class="form-control" placeholder="">
            </div>
          </div>
        </div>

        <!-- <h5 class="text-black block-title">Pengakuan</h5>
        <div class="row">
          <div class="col-md-12">
            <p class="text-black">
              Saya dengan ini mengaku bahawa segala maklumat yang diberikan di atas adalah benar dan tepat. Saya juga bersetuju untuk mematuhi syarat-syarat dan peraturan-peraturan yang telah ditetapkan oleh pihak ECAQUE ENTERPRISE
            </p>
          </div>
        </div> -->

        <div class="row m-t-20">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary" name="button">Tambah <i class="fa fa-send m-l-5"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

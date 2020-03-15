<div class="row row-same-height">
  <div class="col-md-4 b-r b-dashed b-grey sm-b-b">
    <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-20">
      <!-- <i class="fa fa-user fa-2x hint-text"></i> -->
      <!-- <h2 class="bold m-b-0 p-b-0">Maklumat Stokis</h2> -->
      <h3 class="font-montserrat text-uppercase"> Maklumat Stokis</h3>
      <p>Sila pastikan maklumat yang hendak diedit adalah betul</p>
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
          <div class="col-md-7">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Nama Penuh</label>
              <input required id="fullname" name="fullname" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-5 ">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">No. Kad Pengenalan</label>
              <input required id="identificationNo" name="identificationNo" type="text" class="form-control" placeholder="XXXXXX-XX-XXXX">
            </div>
          </div>
        </div>
        <div class="row m-t-5">
          <div class="col-md-4">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Jantina</label>
              <select required data-init-plugin='select2' id="jantina" name="jantina" class="form-control full-width" >
                <?php getJantina(); ?>
              </select>
              <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Warganegara</label>
              <select required data-init-plugin='select2' id="nationality" name="nationality" class="form-control full-width" >
                <?php getNegara(); ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="">Bangsa</label>
              <select required data-init-plugin='select2' id="bangsa" name="bangsa" class="form-control full-width" >
                <?php getKeturunan(); ?>
              </select>
            </div>
          </div>
        </div>

        <h5 class="text-black block-title font-montserrat text-uppercase small bold">Alamat Surat Menyurat</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Alamat Premis</label>
              <input required id="alamat" name="alamat" type="text" class="form-control" placeholder="">
            </div>
          </div>
        </div>
        <div class="row m-t-5">
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Bandar</label>
              <input required id="bandar" name="bandar" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default form-group-default-select2">
              <label class="control-label">Negeri</label>
              <select required data-init-plugin='select2' id="negeri" name="negeri" class="form-control full-width" >
                <?php getNegeri(); ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Poskod</label>
              <input required id="poskod" name="poskod" type="text" class="form-control" placeholder="">
            </div>
          </div>
        </div>

        <h5 class="text-black block-title font-montserrat text-uppercase small bold">Maklumat Telekomunikasi</h5>

        <div class="row">
          <div class="col-md-7">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Alamat emel</label>
              <input required id="email" name="email" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">No. Telefon</label>
              <input required id="phone" name="phone" type="text" class="form-control" placeholder="">
            </div>
          </div>
        </div>

        <h5 class="text-black block-title font-montserrat text-uppercase small bold">Maklumat Media Sosial</h5>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Facebook</label>
              <input id="facebook" name="facebook" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">Instagram</label>
              <input id="instagram" name="instagram" type="text" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
              <label class="control-label">linkedin</label>
              <input id="linkedin" name="linkedin" type="text" class="form-control" placeholder="">
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
            <button type="submit" class="btn btn-primary" name="button">Save <i class="fa fa-send m-l-5"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

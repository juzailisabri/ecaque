<div class=" container no-padding    container-fixed-lg">
  <div class="inner" style="transform: translateY(0px); opacity: 1;">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Papan Pemuka</li>
    </ol>
  </div>
</div>
<div class="content sm-gutter">
  <div class="container  no-padding">
    <div class="row visible-xs">
      <div class="col-lg-12 d-flex align-items-stretch ">
        <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle d-flex flex-column align-self-stretch">
          <div class="card-header top-right">
            <div class="card-controls">
              <ul>
                <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i class="portlet-icon portlet-icon-refresh"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="padding-25">
            <div class="pull-left">
              <h2 class="text-success no-margin font-montserrat text-uppercase">eCaque Dashboard</h2>
              <p class="no-margin">Order / Sales / Agents</p>
            </div>
            <!-- <h3 class="pull-right semi-bold"><sup>
            <small class="semi-bold m-r-10">RM </small>
          </sup> <span id="salesValue">00.00</span>
        </h3> -->
        <div class="clearfix"></div>
      </div>
      <div class="auto-overflow widget-11-2-tablea">
        <table class="table table-condensed table-hover">
          <tbody>
            <tr>
              <td class="font-montserrat all-caps fs-12 w-75a">Pending Delivery</td>
              <td class="w-25a text-right">
                <span class="font-montserrat fs-18 "><b id="pendingDeliver"></b> Orders</span>
              </td>
            </tr>
            <tr>
              <td class="font-montserrat all-caps fs-12 w-75a">Pending Payment</td>
              <td class="w-25a text-right">
                <span class="font-montserrat fs-18 "><b id="pendingPayment"></b> Orders</span>
              </td>
            </tr>
            <tr>
              <td class="font-montserrat all-caps fs-12 w-50a">Total Sales</td>
              <td class="w-50a text-right">
                <span class="font-montserrat fs-18 "> <sup class="p-r-5">RM</sup> <b id="totalSales"></b></span>
              </td>
            </tr>
            <tr>
              <td class="font-montserrat all-caps fs-12 w-75a">Active Agent</td>
              <td class="w-25a text-right">
                <span class="font-montserrat fs-18 "><b id="dropshipAgentCount"></b> Agents</span>
              </td>
            </tr>
            <tr>
              <td class="font-montserrat all-caps fs-12 w-75a">Agent Pending Approval</td>
              <td class="w-25a text-right">
                <span class="font-montserrat fs-18 "><b id="pendingdropshipAgentCount"></b> Agents</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="padding-25 mt-auto">
        <p class="small no-margin">
          <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
          <span class="hint-text ">See Details in Customer Order</span>
        </p>
      </div>
    </div>
  </div>
    </div>
    <div class="row hidden-xs">
      <div class="col-lg-3 col-sm-6 d-flex flex-column">
        <div class="card no-border widget-loader-bar m-b-10">
          <div class="container-xs-height full-height">
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="card-header  top-left top-right">
                  <div class="card-title">
                    <span class="font-montserrat fs-11 all-caps">Pending Delivery <i class="fa fa-chevron-right"></i>
                    </span>
                  </div>
                  <div class="card-controls">
                    <ul>
                      <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="p-l-20 p-t-50 p-b-40 p-r-20">
                  <h3 class="no-margin p-b-5"><span id="pendingDeliver"></span> Orders</h3>
                  <span class="small hint-text pull-left">Pending Delivery order</span>
                  <!-- <span class="pull-right small text-primary">$23,000</span> -->
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-bottom">
                <div class="progress progress-small m-b-0">
                  <div class="progress-bar progress-bar-primary" style="width:100%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 d-flex flex-column">
        <div class="card no-border widget-loader-bar m-b-10">
          <div class="container-xs-height full-height">
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="card-header  top-left top-right">
                  <div class="card-title">
                    <span class="font-montserrat fs-11 all-caps">Payment Pending <i class="fa fa-chevron-right"></i>
                    </span>
                  </div>
                  <div class="card-controls">
                    <ul>
                      <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="p-l-20 p-t-50 p-b-40 p-r-20">
                  <h3 class="no-margin p-b-5"><span id="pendingPayment"></span> Orders</h3>
                  <span class="small hint-text pull-left">Please follow up with client</span>
                  <!-- <span class="pull-right small text-primary">$23,000</span> -->
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-bottom">
                <div class="progress progress-small m-b-0">
                  <div class="progress-bar progress-bar-primary" style="width:100%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 d-flex flex-column">
        <div class="card no-border widget-loader-bar m-b-10">
          <div class="container-xs-height full-height">
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="card-header  top-left top-right">
                  <div class="card-title">
                    <span class="font-montserrat fs-11 all-caps">Total Sales <i class="fa fa-chevron-right"></i>
                    </span>
                  </div>
                  <div class="card-controls">
                    <ul>
                      <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="p-l-20 p-t-50 p-b-40 p-r-20">
                  <h3 class="no-margin p-b-5"> <sup>MYR</sup> <span id="totalSales"></span> </h3>
                  <span class="small hint-text pull-left" id=""> <span id="salespercentage">0%</span>  of total goal</span>
                  <span class="pull-right small text-primary">MYR 10,000.00</span>
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-bottom">
                <div class="progress progress-small m-b-0">
                  <div class="progress-bar progress-bar-primary" id="salesprogressbar" style="width:71%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 d-flex flex-column">
        <div class="card no-border widget-loader-bar m-b-10">
          <div class="container-xs-height full-height">
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="card-header  top-left top-right">
                  <div class="card-title">
                    <span class="font-montserrat fs-11 all-caps">Dropship Agent <i class="fa fa-chevron-right"></i>
                    </span>
                  </div>
                  <div class="card-controls">
                    <ul>
                      <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-top">
                <div class="p-l-20 p-t-50 p-b-40 p-r-20">
                  <h3 class="no-margin p-b-5"><span id="dropshipAgentCount"></span> Agents </h3>
                  <span class="small hint-text pull-left">Active Agent</span>
                  <!-- <span class="pull-right small text-primary">$23,000</span> -->
                </div>
              </div>
            </div>
            <div class="row-xs-height">
              <div class="col-xs-height col-bottom">
                <div class="progress progress-small m-b-0">
                  <div class="progress-bar progress-bar-primary" style="width:100%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 sm-m-t-10 d-flex align-items-stretch hidden-xs">
        <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle d-flex flex-column align-self-stretch">
          <div class="card-header top-right">
            <div class="card-controls">
              <ul>
                <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i class="portlet-icon portlet-icon-refresh"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="padding-25">
            <div class="pull-left">
              <h2 class="text-success no-margin font-montserrat text-uppercase">Cakes #</h2>
              <p class="no-margin">Number of Cake Needed</p>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="auto-overflow widget-11-2-tablea">
            <table class="table table-condensed table-hover">
              <tbody id="tbodyCakeNeeded">

              </tbody>
            </table>
          </div>
          <div class="padding-25 mt-auto">
            <p class="small no-margin">
              <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
              <span class="hint-text ">See Details in Customer Order</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-9 sm-m-t-10 d-flex align-items-stretch">
        <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle d-flex flex-column align-self-stretch">
          <div class="card-header top-right">
            <div class="card-controls">
              <ul>
                <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i class="portlet-icon portlet-icon-refresh"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="padding-25">
            <div class="pull-left">
              <h2 class="text-success no-margin font-montserrat text-uppercase">eCaque's Fruit Cake</h2>
              <p class="no-margin">Latest sales transaction</p>
            </div>
            <!-- <h3 class="pull-right semi-bold"><sup>
              <small class="semi-bold m-r-10">RM </small>
            </sup> <span id="salesValue">00.00</span>
          </h3> -->
          <div class="clearfix"></div>
        </div>
        <div class="auto-overflow widget-11-2-table">
          <table class="table table-condensed table-hover">
            <tbody id="tbodyLatestTransaction">

            </tbody>
          </table>
        </div>
        <div class="padding-25 mt-auto">
          <p class="small no-margin">
            <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
            <span class="hint-text ">See Details in Customer Order</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">

function getDashboardData(){
  var fd = new FormData();
  fd.append("func","getDashboardAdmin");
  $.ajax({
    type: 'POST',
    url: "db",
    data: fd,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
      $("[id='pendingDeliver']").html(data["s3"]);
      $("[id='pendingPayment']").html(data["s2"]);
      $("[id='totalSales']").html(data["s1"]);
      $("[id='dropshipAgentCount']").html(data["s4"]);
      $("[id='pendingdropshipAgentCount']").html(data["s5"]);



      $("#tbodyLatestTransaction").html(data["t1"]);
      $("#tbodyCakeNeeded").html(data["t2"]);
      salesprogressbar(data["s1"]);
    },
    error: function(data) {
      // saAlert3("Error","Session Log Out Error","warning");
    }
  });
}

function salesprogressbar(current){
  var target = 10000.00;
  var percent = current/target * 100;
  $("#salesprogressbar").css("width",percent+"%");
  $("#salespercentage").html(percent+"%");
}

getDashboardData();

if (typeof DASHBOARDINT !== 'undefined') {
  clearInterval(DASHBOARDINT);
}

DASHBOARDINT = setInterval(getDashboardData,10000);

</script>

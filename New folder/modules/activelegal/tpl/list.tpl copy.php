<!-- start page content wrapper-->
<div class="page-content-wrapper">
  <!-- start page content-->
  <div class="page-content">
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Active Legal</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0 align-items-center">
            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Active Legal List</li>
          </ol>
        </nav>
      </div>
      <div class="ms-auto ">
        <div class="btn-group">
          <button type="button" class="btn btn-primary"
            onclick="window.location.href='<?= ROOT_DIR ?>activelegal/information.html';"><i
              class="fadeIn animated bx bx-plus"></i>New Legal</button>
        </div>
      </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-12 col-lg">

                <input class="form-control" type="text" placeholder="Search by Marketing">
              </div>
              <div class="col-12 col-lg">

                <input class="form-control" type="text" placeholder="Search by Client">
              </div>
              <div class="col-12 col-lg">

                <input class="form-control" type="text" placeholder="Search by Firm">
              </div>
              <div class="col-12 col-lg">

                <input type="date" class="form-control" placeholder="Date Action Date" readonly="true" />
                <span class="small text-muted">Last Action Date</span>

              </div>

            </div><!--end row-->
          </div>

          <div class="card-body">
            <div class="row g-3">

              <div class="col-12 col-lg">

                <input type="date" class="form-control" placeholder="From Date" readonly="true" />
                <span class="small text-muted">From Date</span>
              </div>
              <div class="col-12 col-lg">

                <input type="date" class="form-control" placeholder="To Date" readonly="true" />
                <span class="small text-muted">To Date</span>
              </div>
              <div class="col-12 col-lg">

                <button type="button" class="btn btn-primary">Search</button>
              </div>
              <div class="col-12 col-lg">


              </div>
            </div><!--end row-->
          </div>

        </div>

        <div class="card">
          <div class="card-body">
            <div class="col text-end py-2">
              <button type="button" class="btn btn-sm btn-outline-primary px-1">
                <i class="lni lni-download"></i>
              </button>
            </div>
            <div class="table-responsive mt-3">
              <table class="table align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Date</th>
                    <th>Marketing</th>
                    <th>Client</th>
                    <th>Present <br>Legal Firm</th>
                    <th>Case <br>Status</th>
                    <th>Claim <br>Amount</th>
                    <th>Received <br>Claim</th>
                    <th>Balance <br>to Claim</th>
                    <th>Expense</th>
                    <th>Last <br>Action & Date</th>

                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>25/05/2022</td>
                    <td>Anju</td>
                    <td>Al Rajhi Construction LLC</td>
                    <td>Ameer (Third party)</td>
                    <td>Open</td>
                    <td>833,837.50</td>
                    <td>10,000.00</td>
                    <td>971,212.50</td>
                    <td>147,135.00</td>

                    <td>Date :25/05/2022
                      <p>Documents submitted to Al Kabban & Associates for Filing case</p>
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-success"
                          onclick="window.location.href='<?= ROOT_DIR ?>activelegal/view.html';"><i
                            class="lni lni-eye"></i></button>
                        <button type="button" class="btn btn-dark"
                          onclick="window.location.href='<?= ROOT_DIR ?>activelegal/information.html';"><i
                            class="fadeIn animated bx bx-pencil"></i></button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                          data-bs-target="#exampleModal"><i class="lni lni-shuffle"></i></button>

                        <button type="button" class="btn btn-danger"><i class="lni lni-trash"></i></button>
                      </div>
                    </td>
                  </tr>


                  <tr>
                    <td>21/05/2022</td>
                    <td>Kiran</td>
                    <td>Thomas Bennett Group Of Companies</td>
                    <td>Dinesh (Tihird Pary)</td>
                    <td>Open</td>
                    <td>19,865.50</td>
                    <td></td>
                    <td>19,865.50</td>
                    <td>7,705.00 </td>

                    <td>Date :21/05/2022
                      <p>There is an order to attach the vehicles of the company.
                        Email Received on 26-01-2020</p>
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-success"
                          onclick="window.location.href='<?= ROOT_DIR ?>activelegal/view.html';"><i
                            class="lni lni-eye"></i></button>
                        <button type="button" class="btn btn-dark"
                          onclick="window.location.href='<?= ROOT_DIR ?>activelegal/information.html';"><i
                            class="fadeIn animated bx bx-pencil"></i></button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                          data-bs-target="#exampleModal"><i class="lni lni-shuffle"></i></button>

                        <button type="button" class="btn btn-danger"><i class="lni lni-trash"></i></button>
                      </div>
                    </td>
                  </tr>


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end page content-->



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Shifting Legal Firm/Party</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>

              <div class="mb-3">
                <label class="form-label">Category:</label>
                <select class="form-control">
                  <option value="">Third Party</option>
                  <option value="">Debt Collector</option>
                  <option value="">Legal Firm</option>
                  <option value="">Legal Team</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label"> Firm/Party:</label>
                <input type="text" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Shifted Date:</label>
                <input type="text" class="form-control">
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Shifted</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
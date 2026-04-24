   <!-- start page content wrapper-->
   <div class="page-content-wrapper">
          <!-- start page content-->
         <div class="page-content">

          <!--start breadcrumb-->
          <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Form Elements</li>
                </ol>
              </nav>
            </div>
            <div class="ms-auto">
              <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">Settings</button>
                <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                  <a class="dropdown-item" href="javascript:;">Another action</a>
                  <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
              </div>
            </div>
          </div>
          <!--end breadcrumb-->

          <div class="col-xl-12 mx-auto">

    <h6 class="mb-0 text-uppercase">Single Select Examples</h6>
     <hr/>
    <div class="card">
      <div class="card-body">

        <div class="mb-4">
          <label for="single-select-field" class="form-label">Basic single select</label>
          <select class="form-select" id="single-select-field" data-placeholder="Choose one thing">
            <option></option>
            <option>Reactive</option>
            <option>Solution</option>
            <option>Conglomeration</option>
            <option>Algoritm</option>
            <option>Holistic</option>
          </select>
        </div>

        <div class="mb-4">
          <label for="single-select-optgroup-field" class="form-label">Single select w/ optgroup</label>
          <select class="form-select" id="single-select-optgroup-field" data-placeholder="Choose one thing">
            <option></option>
            <optgroup label="Group 1">
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
            </optgroup>
            <optgroup label="Group 2">
              <option>Algoritm</option>
              <option>Holistic</option>
            </optgroup>
          </select>
        </div>

        <div class="mb-4">
          <label for="single-select-clear-field" class="form-label">Single select w/ allow clear</label>
           <select class="form-select" id="single-select-clear-field" data-placeholder="Choose one thing">
             <option></option>
             <option>Reactive</option>
             <option>Solution</option>
             <option>Conglomeration</option>
             <option>Algoritm</option>
             <option>Holistic</option>
           </select>
         </div>

         <div class="mb-0">
          <label for="single-select-disabled-field" class="form-label">Disabled single select</label>
          <select class="form-select" id="single-select-disabled-field" data-placeholder="Choose one thing" disabled>
            <option></option>
            <option>Reactive</option>
            <option>Solution</option>
            <option>Conglomeration</option>
            <option>Algoritm</option>
            <option>Holistic</option>
          </select>
        </div>

      </div>
    </div>


    <h6 class="mb-0 text-uppercase">Multiple select</h6>
     <hr/>
    <div class="card">
       <div class="card-body">

      <div class="mb-4">
        <label for="multiple-select-field" class="form-label">Basic multiple select</label>
        <select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
          <option selected>Christmas Island</option>
          <option selected>South Sudan</option>
          <option selected>Jamaica</option>
          <option>Kenya</option>
          <option>French Guiana</option>
          <option>Mayotta</option>
          <option>Liechtenstein</option>
          <option>Denmark</option>
          <option>Eritrea</option>
          <option>Gibraltar</option>
          <option>Saint Helena, Ascension and Tristan da Cunha</option>
          <option>Haiti</option>
          <option>Namibia</option>
          <option>South Georgia and the South Sandwich Islands</option>
          <option>Vietnam</option>
          <option>Yemen</option>
          <option>Philippines</option>
          <option>Benin</option>
          <option>Czech Republic</option>
          <option>Russia</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="multiple-select-optgroup-field" class="form-label">Multiple select w/ optgroup</label>
        <select class="form-select" id="multiple-select-optgroup-field" data-placeholder="Choose anything" multiple>
          <optgroup label="Group 1">
            <option selected>Christmas Island</option>
            <option>South Sudan</option>
            <option selected>Jamaica</option>
            <option>Kenya</option>
            <option>French Guiana</option>
            <option>Mayotta</option>
          </optgroup>
          <optgroup label="Group 2">
            <option>Liechtenstein</option>
            <option>Denmark</option>
            <option>Eritrea</option>
            <option>Gibraltar</option>
            <option>Saint Helena, Ascension and Tristan da Cunha</option>
            <option>Haiti</option>
            <option>Namibia</option>
          </optgroup>
          <optgroup label="Group 3">
            <option>South Georgia and the South Sandwich Islands</option>
            <option>Vietnam</option>
            <option>Yemen</option>
            <option>Philippines</option>
            <option>Benin</option>
            <option>Czech Republic</option>
            <option>Russia</option>
          </optgroup>
        </select>
      </div>


      <div class="mb-4">
        <label for="multiple-select-clear-field" class="form-label">Multiple select w/ allow clear</label>
        <select class="form-select" id="multiple-select-clear-field" data-placeholder="Choose anything" multiple>
          <option>Christmas Island</option>
          <option>South Sudan</option>
          <option>Jamaica</option>
          <option>Kenya</option>
          <option>French Guiana</option>
          <option selected>Mayotta</option>
          <option selected>Liechtenstein</option>
          <option>Denmark</option>
          <option>Eritrea</option>
          <option>Gibraltar</option>
          <option>Saint Helena, Ascension and Tristan da Cunha</option>
          <option>Haiti</option>
          <option>Namibia</option>
          <option>South Georgia and the South Sandwich Islands</option>
          <option>Vietnam</option>
          <option>Yemen</option>
          <option>Philippines</option>
          <option>Benin</option>
          <option>Czech Republic</option>
          <option>Russia</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="multiple-select-custom-field" class="form-label">Multiple select w/ custom entries</label>
        <select class="form-select" id="multiple-select-custom-field" data-placeholder="Choose anything" multiple>
          <option>Christmas Island</option>
          <option>South Sudan</option>
          <option>Jamaica</option>
          <option>Kenya</option>
          <option>French Guiana</option>
          <option>Mayotta</option>
          <option>Liechtenstein</option>
          <option>Denmark</option>
          <option>Eritrea</option>
          <option>Gibraltar</option>
          <option>Saint Helena, Ascension and Tristan da Cunha</option>
          <option>Haiti</option>
          <option>Namibia</option>
          <option>South Georgia and the South Sandwich Islands</option>
          <option>Vietnam</option>
          <option>Yemen</option>
          <option>Philippines</option>
          <option>Benin</option>
          <option>Czech Republic</option>
          <option>Russia</option>
        </select>
      </div>

      <div class="mb-0">
        <label for="multiple-select-disabled-field" class="form-label">Disabled multiple select</label>
        <select class="form-select" id="multiple-select-disabled-field" data-placeholder="Choose anything" multiple disabled>
          <option>Christmas Island</option>
          <option>South Sudan</option>
          <option>Jamaica</option>
          <option>Kenya</option>
          <option>French Guiana</option>
          <option>Mayotta</option>
          <option>Liechtenstein</option>
          <option>Denmark</option>
          <option>Eritrea</option>
          <option>Gibraltar</option>
          <option>Saint Helena, Ascension and Tristan da Cunha</option>
          <option>Haiti</option>
          <option>Namibia</option>
          <option>South Georgia and the South Sandwich Islands</option>
          <option>Vietnam</option>
          <option>Yemen</option>
          <option>Philippines</option>
          <option>Benin</option>
          <option>Czech Republic</option>
          <option>Russia</option>
        </select>
      </div>


       </div>
    </div>



    <h6 class="mb-0 text-uppercase">Select with input groups</h6>
     <hr/>
    <div class="card">
       <div class="card-body">

      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Prepend</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <div class="input-group-text">Prepend</div>
            <select class="form-select" id="prepend-text-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="input-group">
            <div class="input-group-text">Prepend</div>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-text-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Button</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button">Prepend</button>
            <select class="form-select" id="prepend-button-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="input-group">
            <button class="btn btn-outline-secondary" type="button">Prepend</button>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-button-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Dropdown</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Prepend</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" id="prepend-dropdown-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="input-group mb-0">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Prepend</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-dropdown-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Dropdown Toggle</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary">Prepend</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" id="prepend-toggle-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="input-group mb-0">
            <button class="btn btn-outline-secondary">Prepend</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-toggle-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
          </div>
        </div>
      </div>



      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Append</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <select class="form-select" id="append-text-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <div class="input-group-text">Append</div>
          </div>

          <div class="input-group mb-0">
            <select class="form-select" data-placeholder="Choose anything" id="append-text-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <div class="input-group-text">Append</div>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select Append with Button</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <select class="form-select" id="append-button-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary" type="button">Append</button>
          </div>

          <div class="input-group mb-0">
            <select class="form-select" data-placeholder="Choose anything" id="append-button-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary" type="button">Append</button>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select Append with Dropdown</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <select class="form-select" id="append-dropdown-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Append</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>

          <div class="input-group mb-0">
            <select class="form-select" data-placeholder="Choose anything" id="append-dropdown-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Append</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select Append with Dropdown Toggle</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <select class="form-select" id="append-toggle-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary">Append</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>

          <div class="input-group mb-0">
            <select class="form-select" data-placeholder="Choose anything" id="append-toggle-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary">Append</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Prepend & Append</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <div class="input-group-text">Prepend</div>
            <select class="form-select" id="prepend-append-text-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <div class="input-group-text">Append</div>
          </div>

          <div class="input-group mb-0">
            <div class="input-group-text">Prepend</div>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-append-text-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <div class="input-group-text">Append</div>
          </div>
        </div>
      </div>



      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Button Prepend & Append</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button">Prepend</button>
            <select class="form-select" id="prepend-append-button-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary" type="button">Append</button>
          </div>

          <div class="input-group mb-0">
            <button class="btn btn-outline-secondary" type="button">Prepend</button>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-append-button-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary" type="button">Append</button>
          </div>
        </div>
      </div>


      <div class="card shadow-none border">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Dropdown Button Prepend & Append</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Prepend</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" id="prepend-append-dropdown-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Append</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>

          <div class="input-group mb-0">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Prepend</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-append-dropdown-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Append</button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>
        </div>
      </div>


      <div class="card shadow-none border mb-0">
        <div class="card-header bg-light">
          <h6 class="mb-0">Select with Dropdown toggle Prepend & Append</h6>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary">Prepend</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" id="prepend-append-toggle-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
            <button class="btn btn-outline-secondary">Append</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>

          <div class="input-group mb-0">
            <button class="btn btn-outline-secondary">Prepend</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <select class="form-select" data-placeholder="Choose anything" id="prepend-append-toggle-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            <button class="btn btn-outline-secondary">Append</button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </div>

        </div>
      </div>


      </div>
    </div>


    <h6 class="mb-0 text-uppercase">Select with Sizing</h6>
     <hr/>
    <div class="card">
       <div class="card-body">

      <div class="card border shadow-none">
        <div class="card-header bg-light">
          <h6 class="mb-0">Small Select2 Options</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <select class="form-select form-select-sm" id="small-bootstrap-class-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="mb-0">
            <select class="form-select form-select-sm" data-placeholder="Choose anything" id="small-bootstrap-class-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
            </div>
        </div>
       </div>


       <div class="card border shadow-none mb-0">
        <div class="card-header bg-light">
          <h6 class="mb-0">Large Select2 Options</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <select class="form-select form-select-lg" id="large-bootstrap-class-single-field" data-placeholder="Choose one thing">
              <option></option>
              <option>Reactive</option>
              <option>Solution</option>
              <option>Conglomeration</option>
              <option>Algoritm</option>
              <option>Holistic</option>
            </select>
          </div>

          <div class="mb-0">
            <select class="form-select form-select-lg" data-placeholder="Choose anything" id="large-bootstrap-class-multiple-field" multiple>
              <option>Christmas Island</option>
              <option>South Sudan</option>
              <option>Jamaica</option>
              <option>Kenya</option>
              <option>French Guiana</option>
              <option>Mayotta</option>
              <option>Liechtenstein</option>
              <option>Denmark</option>
              <option>Eritrea</option>
              <option>Gibraltar</option>
              <option>Saint Helena, Ascension and Tristan da Cunha</option>
              <option>Haiti</option>
              <option>Namibia</option>
              <option>South Georgia and the South Sandwich Islands</option>
              <option>Vietnam</option>
              <option>Yemen</option>
              <option>Philippines</option>
              <option>Benin</option>
              <option>Czech Republic</option>
              <option>Russia</option>
            </select>
          </div>
        </div>
       </div>

      </div>
    </div>

  </div>
          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Text Input</h6>
            </div>
            <div class="card-body">
              <input class="form-control form-control-lg mb-3" type="text" placeholder=".form-control-lg" aria-label=".form-control-lg example">
              <input class="form-control mb-3" type="text" placeholder="Default input" aria-label="default input example">
              <input class="form-control form-control-sm mb-3" type="text" placeholder=".form-control-sm" aria-label=".form-control-sm example">
              <input class="form-control mb-3" type="text" placeholder="Disabled input" aria-label="Disabled input example" disabled="">
              <input class="form-control mb-3" type="text" placeholder="Disabled readonly input" aria-label="Disabled input example" disabled="" readonly="">
              <input class="form-control" type="text" placeholder="Readonly input here..." aria-label="readonly input example" readonly="">
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Select Input</h6>
            </div>
            <div class="card-body">
              <select class="form-select mb-3" aria-label="Default select example">
                <option selected="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
              <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
              <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example">
                <option selected="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
              <select class="form-select" aria-label="Disabled select example" disabled="">
                <option selected="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>


          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">File Input</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" id="formFile">
              </div>
              <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                <input class="form-control" type="file" id="formFileMultiple" multiple="">
              </div>
              <div class="mb-3">
                <label for="formFileDisabled" class="form-label">Disabled file input example</label>
                <input class="form-control" type="file" id="formFileDisabled" disabled="">
              </div>
              <div class="mb-3">
                <label for="formFileSm" class="form-label">Small file input example</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file">
              </div>
              <div>
                <label for="formFileLg" class="form-label">Large file input example</label>
                <input class="form-control form-control-lg" id="formFileLg" type="file">
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Data Lists</h6>
            </div>
            <div class="card-body">
              <label for="exampleDataList" class="form-label">Datalist example</label>
              <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
              <datalist id="datalistOptions">
                <option value="San Francisco">
                  </option><option value="New York">
                    </option><option value="Seattle">
                      </option><option value="Los Angeles">
                        </option><option value="Chicago">
                    </option>
                  </datalist>
            </div>
          </div>


          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">CHECKBOXES AND RADIOS</h6>
            </div>
            <div class="card">
							<div class="card-body">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
									<label class="form-check-label" for="flexCheckChecked">Checked checkbox</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
									<label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled="">
									<label class="form-check-label" for="flexCheckDisabled">Disabled checkbox</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked="" disabled="">
									<label class="form-check-label" for="flexCheckCheckedDisabled">Disabled checked checkbox</label>
								</div>
								<hr>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
									<label class="form-check-label" for="flexRadioDefault1">Default radio</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="">
									<label class="form-check-label" for="flexRadioDefault2">Default checked radio</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled="">
									<label class="form-check-label" for="flexRadioDisabled">Disabled radio</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked="" disabled="">
									<label class="form-check-label" for="flexRadioCheckedDisabled">Disabled checked radio</label>
								</div>
								<hr>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
									<label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
								</div>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
									<label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
								</div>
								<div class="form-check-danger form-check form-switch">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDanger" checked="">
									<label class="form-check-label" for="flexSwitchCheckCheckedDanger">Checked switch checkbox input</label>
								</div>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled="">
									<label class="form-check-label" for="flexSwitchCheckDisabled">Disabled switch checkbox input</label>
								</div>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" checked="" disabled="">
									<label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Disabled checked switch checkbox input</label>
								</div>
								<hr>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
									<label class="form-check-label" for="inlineCheckbox1">1</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
									<label class="form-check-label" for="inlineCheckbox2">2</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled="">
									<label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
									<label class="form-check-label" for="inlineRadio1">1</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
									<label class="form-check-label" for="inlineRadio2">2</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled="">
									<label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
								</div>
							</div>
						</div>
          </div>


          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Input Mask</h6>
            </div>
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label class="form-label">Date:</label>
                  <input type="date" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Date time:</label>
                  <input type="datetime-local" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Email:</label>
                  <input type="email" class="form-control" placeholder="example@gmail.com">
                </div>
                <div class="mb-3">
                  <label class="form-label">Password:</label>
                  <input type="password" class="form-control" value="........">
                </div>
                <div class="mb-3">
                  <label class="form-label">Input File:</label>
                  <input type="file" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Month:</label>
                  <input type="month" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Search:</label>
                  <input type="search" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Tel:</label>
                  <input type="tel" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Time:</label>
                  <input type="time" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Url:</label>
                  <input type="url" class="form-control" placeholder="https://example.com/users/">
                </div>
                <div class="mb-3">
                  <label class="form-label">Week:</label>
                  <input type="week" class="form-control">
                </div>
              </form>
            </div>
          </div>


          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Input Range</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="customRange1" class="form-label">Example range</label>
                <input type="range" class="form-range" id="customRange1">
              </div>
              <div class="mb-3">
                <label for="disabledRange" class="form-label">Disabled range</label>
                <input type="range" class="form-range" id="disabledRange" disabled="">
              </div>
              <div class="mb-3">
                <label for="customRange2" class="form-label">Example range</label>
                <input type="range" class="form-range" min="0" max="5" id="customRange2">
              </div>
            </div>
          </div>


          <div class="card">
            <div class="card-header">
              <h6 class="mb-0">Input Tags</h6>
            </div>
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label class="form-label">Basic</label>
                  <input type="text" class="form-control" data-role="tagsinput" value="jQuery,Script,Net">
                </div>
                <div class="mb-3">
                  <label class="form-label">Multi Select</label>
                  <select multiple data-role="tagsinput">
                    <option value="Amsterdam">Amsterdam</option>
                    <option value="Washington">Washington</option>
                    <option value="Sydney">Sydney</option>
                    <option value="Beijing">Beijing</option>
                    <option value="Cairo">Cairo</option>
                  </select>
                </div>
              </form>
            </div>
          </div>


          </div>
          <!-- end page content-->
         </div>
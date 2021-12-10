<section class="pricing-section sec-pad" id="pricing">
  <div class="container-fluid">
    <div class="annual-sales brands-list">
      <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
      <p class="notice" style="clear:both;">
        <?php  echo $notice;?>
      </p>
      <?php  endif;?>
      <div class="head">
        <h2 class="d-inline-block">Reports</h2>
        <div class="float-right">
          <form class="form-inline float-left mr-3" method="post" action="<?php  echo site_url('member/admin/reports') ?>">
            <select name="month" class="form-control mr-sm-2" >
              <option value="01" <?php if($month == '01'){ ?> Selected <?php } ?> >January</option>
              <option value="02" <?php if($month == '02'){ ?> Selected <?php } ?> >Febraury</option>
              <option value="03" <?php if($month == '03'){ ?> Selected <?php } ?> >March</option>
              <option value="04" <?php if($month == '04'){ ?> Selected <?php } ?> >April</option>
              <option value="05" <?php if($month == '05'){ ?> Selected <?php } ?> >May</option>
              <option value="06" <?php if($month == '06'){ ?> Selected <?php } ?> >June</option>
              <option value="07" <?php if($month == '07'){ ?> Selected <?php } ?> >July</option>
              <option value="08" <?php if($month == '08'){ ?> Selected <?php } ?> >August</option>
              <option value="09" <?php if($month == '09'){ ?> Selected <?php } ?> >September</option>
              <option value="10" <?php if($month == '10'){ ?> Selected <?php } ?> >October</option>
              <option value="11" <?php if($month == '11'){ ?> Selected <?php } ?> >November</option>
              <option value="12" <?php if($month == '12'){ ?> Selected <?php } ?> >December</option>
            </select>

            <select name="year" class="form-control mr-sm-2" >
              <option value="2019" <?php if($year == '2019'){ ?> Selected <?php } ?>>2019</option>
              <option value="2020" <?php if($year == '2020'){ ?> Selected <?php } ?>>2020</option>
              <option value="2021" <?php if($year == '2021'){ ?> Selected <?php } ?>>2021</option>
              <option value="2021" <?php if($year == '2022'){ ?> Selected <?php } ?>>2022</option>
            </select>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </div>
      <div class="data-table">
        <div class="table-responsive">
          <table class="table table-bordered table-striped"  id="sampleTable" style="width:100%">
            <thead>
              <tr>
                <th scope="col">Amount</th>
               
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>$<?php  echo $business;?></td>
                <td><?php  echo $member['my_ref_code']?></td>
               
                
              </tr>
             
            </tbody>
          </table>
        </div>
      </div>
	  
      
    </div>
  </div>
  <!-- /.thm-container -->
</section>

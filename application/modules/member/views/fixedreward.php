
<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Fixed Reward</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Total Business = $<?php echo $downline_business; ?></h3>
            <br />
            <h3 class="text-white mb-0"><?php echo $left_business. " : ".$rest_member_amount ; ?></h3>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
            <tr>
              <th>Reward Level</th>
              <th>Amout</th>
              <th>On Left Business</th>
              <th>On Right Business</th>
              <th>ID (Left)</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($my_reward) > 0){ for($i=0;$i<count($my_reward); $i++){ ?>
            <tr>
              <td><?php echo $my_reward[$i]['step']; ?></td>
              <td>$<?php echo $my_reward[$i]['amount']; ?></td>
              <td>$<?php echo $my_reward[$i]['first_chain_business']; ?></td>
              <td>$<?php echo $my_reward[$i]['rest_chain_business']; ?></td>
              <td><?php echo $this->user->get_id_by_userid($my_reward[$i]['first_chain_user_id']); ?></td>
              <td><?php echo $my_reward[$i]['date']; ?></td>
            </tr>
            <?php } }else{ ?>
            <tr>
              <td colspan="7"><div class="alert alert-danger">No Fixed Reward grabbed yet.</div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="float-right pagination"><?php echo $pager; ?></div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->

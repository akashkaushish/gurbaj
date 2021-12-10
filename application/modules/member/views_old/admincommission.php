<div class="dashboard-main">
  <div class="container-fluid">
    <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice" style="clear:both;">
      <?php  echo $notice;?>
    </p>
    <?php  endif;?>
    <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
    <div class="alert alert-success">
      <?php  echo $success;?>
    </div>
    <?php  endif;?>
    <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
    <div class="alert alert-danger">
      <?php  echo $error;?>
    </div>
    <?php  endif;?>
    <div class="dashboard-top">
      <h3>Admin Commission List</h3>
      <div class="data-table">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
               <th>#</th>
                  <th>Name</th>
                  <th>Total Amount</th>
                  <th>Amount After Discount</th>
                  <th>Charges</th>
                  <th>Commission Percentage</th>
                  <th>Commission Reason</th>
                  <th>Date</th>
              </tr>
            </thead>
            <tbody>
                <?php if(count($commission) > 0){ for($i=0;$i<count($commission); $i++){ ?>
                <tr>
                  <td><?php echo $i+1; ?></td>
                  <td>$ <?php echo $commission[$i]['amount']; ?></td>
                  <td><?php echo $commission[$i]['total_amount']; ?></td>
                  <td><?php echo $commission[$i]['amount_after_discount']; ?></td>
                  <td><?php echo $commission[$i]['discounted_amount']; ?></td>
                  <td><?php echo $commission[$i]['commission_percentage']; ?></td>
                  <td><?php echo $commission[$i]['commission_reason']; ?></td>
                  <td><?php echo $commission[$i]['date_created']; ?></td>
                  <td></td>
                </tr>
                <?php } }else{ ?>
                <tr>
                  <td colspan="6"><div class="alert alert-danger">No request available.</div></td>
                </tr>
                <?php } ?>
              </tbody>
          </table>
          <div class="float-right pagination"><?php echo $pager; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

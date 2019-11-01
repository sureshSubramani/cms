
<div class="row">
<?php
if($this->session->userdata('store_code')  && $this->session->userdata('stall_code')){ ?>
<div class='col-lg-12'>
    <div class='col-lg-3 grid-box zoom'>
		<div class="box-contant text-center">
			<a href="<?php base_url()?>sales"><h1 class='text-center'><?php echo $total_sales_products['tsp']; ?></h1>
			  <span>Total Sales Products</span>
      </a>
		</div>
    </div>
    <div class='col-lg-3 grid-box zoom'>
	<div class="box-contant text-center">
	<span class='text-center'> Box - 1 </span>
		</div>
    </div>
    <div class='col-lg-3 grid-box zoom'>
		<div class="box-contant">
			<span class='text-center'> Box - 1 </span>
		</div>
    </div>
    <div class='col-lg-3 grid-box zoom'>
		<div class="box-contant">
			<span class='text-center'> Box - 1 </span>
		</div>
	</div>
</div>
<?php } ?>
    <div class="col-sm-12">
        <div class='text-center'>
            <h3 style="margin-top:10%;">Hi<?php echo " ".ucfirst($this->session->userdata('user_name')); ?>, Welcome!
                </h2><br><br>
                <?php
	        if($this->session->userdata('user_type') == STORE_MANAGER && isset($wastage['count']) && $wastage['count']){  ?>
                <a type="button" class="btn btn-orange btn-md" href="<?php echo base_url();?>wastage">
                    Wastage Approval <?php echo $wastage['count']; ?> Pending
                </a>
                <?php
	        }?>
        </div>
    </div>
</div>
<?php include('header.php'); ?>

            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Investment Plans</h5>
            </div>
        </div>
    </div>
    <!---->
    
    <div>
    </div>    <div>
    </div>       
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="col-md-7">
                        <h6 class="text-primary h5">Invest in a Plan</h6>
                        <p>Make your money work for you and earn profits by investing in our world-class auto-trading packages. </p>
                    </div>
                   <div wire:id="NeI9c1hbwQ9j1vocqzXG" wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;NeI9c1hbwQ9j1vocqzXG&quot;,&quot;name&quot;:&quot;user.investment-plan&quot;,&quot;locale&quot;:&quot;en&quot;,&quot;path&quot;:&quot;dashboard\/buy-plan&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;v&quot;:&quot;acj&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[]},&quot;serverMemo&quot;:{&quot;children&quot;:[],&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;b34d1db9&quot;,&quot;data&quot;:{&quot;planSelected&quot;:[],&quot;amountToInvest&quot;:0,&quot;disabled&quot;:&quot;disabled&quot;,&quot;paymentMethod&quot;:&quot;Account Balance&quot;,&quot;feedback&quot;:&quot;&quot;},&quot;dataMeta&quot;:{&quot;models&quot;:{&quot;planSelected&quot;:{&quot;class&quot;:&quot;App\\Models\\Plans&quot;,&quot;id&quot;:11,&quot;relations&quot;:[],&quot;connection&quot;:&quot;mysql&quot;}}},&quot;checksum&quot;:&quot;aacb3d80d791537e671242f72ca63510fad297dc2012c61dfd2a6361e66fcfc1&quot;}}">
            <div class="mt-4 row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div>
    </div>                    <div>
    </div>                    <div class="card-body">
                        <div class="rounded p-3 mb-4 shadow option2 bg-light border border-primary" id="acnt">
                            <!--<i class="far fa-wallet mr-3"></i>-->
                            <!--<h6 class="mr-2 my-0"></span> <h6>-->
                            <small class="text-muted" style="font-size:0.7rem !important">ACCOUNT BALANCE</small>
                            <h6 class="my-0">
                                $<?php echo number_format($user['total_balance'], 2, '.', ','); ?>
                            </h6>
                        </div>
                        <p>Choose Plan</p>
                        <div class="row">
                            <!---->
                                                        <div class="mb-4 col-lg-4">
    								<div class="card-deck">
    									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
    										<!--<div class="py-0 border-0 card-header">-->
    										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">Starter</span>-->
    										<!--</div>-->
    										<div class="card-body">
    										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Starter</small>
    										    <hr class="my-4 divider divider-fade divider-dark w-100" />
    											<ul class="text-white list-unstyled">
    												<li> 
    													<small style="color:#939598">Minimum Amount:</small>
    													<h6 class="text-white">$1,000</h6>
    												</li>
    												<li> 
    													<small style="color:#939598">Maximum Amount:</small>
    													<h6 class="text-white">$5,000</h6>
    												</li>
    												<!--<li>-->
    												<!--	<small style="color:#939598">ROI:</small>-->
    												<!--	<h6 class="text-white">0% - 0%</h6>-->
    												<!--</li>-->
    												<li class="mb-0">
    													<small style="color:#939598">Returns:</small>
    													<h6 class="text-white">12-15%</h6>
    												</li>
    											</ul>
    											<hr class="my-4 divider divider-fade divider-dark w-100" />
    											                									<!-- Button -->
                									<div class="mt-5">
                										<form method="post" action="deposit.php">
															<input type="hidden" name="csrfmiddlewaretoken" value="cSkA4SpW0W8j4AtPINM4ooPrCjfa5fRYlTUXMqkWYG1x8Tianfz96muT4O1ps24Z">
                											<h6 class="text-white">Amount to invest</h6>
															<input type="number" class="form-control" name="amount" step="any" value="1000" >
                                                          <input type="hidden" class="btn btn btn-neutral w-100" name="plan" value="starter" >
                											<input type="submit" class="btn btn btn-neutral w-100" name="" value="Invest" >
                										</form>
                									</div>
                								    											<!---->
    											<!--	<form action='' method="POST">-->
    											<!--		<input type="hidden" name="_token" value="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">-->
    											<!--		<div class="form-group">-->
    											<!--			<input type="hidden" value="" name="method">-->
    											<!--			<button class="mb-3 btn btn-sm btn-neutral" type='submit'><i-->
    											<!--					class="fa fa-plus"></i> Request withdrawal</button>-->
    											<!--		</div>-->
    											<!--	</form>-->
    											<!---->
    										</div>
    									</div>
    								</div>
                                </div>
                                                            <div class="mb-4 col-lg-4">
    								<div class="card-deck">
    									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
    										<!--<div class="py-0 border-0 card-header">-->
    										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">Basic</span>-->
    										<!--</div>-->
    										<div class="card-body">
    										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Basic</small>
    										    <hr class="my-4 divider divider-fade divider-dark w-100" />
    											<ul class="text-white list-unstyled">
    												<li> 
    													<small style="color:#939598">Minimum Amount:</small>
    													<h6 class="text-white">$5,000</h6>
    												</li>
    												<li> 
    													<small style="color:#939598">Maximum Amount:</small>
    													<h6 class="text-white">$10,000</h6>
    												</li>
    												<!--<li>-->
    												<!--	<small style="color:#939598">ROI:</small>-->
    												<!--	<h6 class="text-white">0% - 0%</h6>-->
    												<!--</li>-->
    												<li class="mb-0">
    													<small style="color:#939598">Returns:</small>
    													<h6 class="text-white">25-35%</h6>
    												</li>
    											</ul>
    											<hr class="my-4 divider divider-fade divider-dark w-100" />
    											                									<!-- Button -->
                									<div class="mt-5">
                										<form method="post" action="deposit.php">
															<input type="hidden" name="csrfmiddlewaretoken" value="cSkA4SpW0W8j4AtPINM4ooPrCjfa5fRYlTUXMqkWYG1x8Tianfz96muT4O1ps24Z">
                											<h6 class="text-white">Amount to invest</h6>
															<input type="number" class="form-control" name="amount" step="any" value="1000" >
                                                          <input type="hidden" class="btn btn btn-neutral w-100" name="plan" value="Basic" >
                											<input type="submit" class="btn btn btn-neutral w-100" name="" value="Invest" >
                										</form>
                									</div>
                								    											<!---->
    											<!--	<form action='' method="POST">-->
    											<!--		<input type="hidden" name="_token" value="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">-->
    											<!--		<div class="form-group">-->
    											<!--			<input type="hidden" value="" name="method">-->
    											<!--			<button class="mb-3 btn btn-sm btn-neutral" type='submit'><i-->
    											<!--					class="fa fa-plus"></i> Request withdrawal</button>-->
    											<!--		</div>-->
    											<!--	</form>-->
    											<!---->
    										</div>
    									</div>
    								</div>
                                </div>
                                                            <div class="mb-4 col-lg-4">
    								<div class="card-deck">
    									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
    										<!--<div class="py-0 border-0 card-header">-->
    										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">Premium</span>-->
    										<!--</div>-->
    										<div class="card-body">
    										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Preumium</small>
    										    <hr class="my-4 divider divider-fade divider-dark w-100" />
    											<ul class="text-white list-unstyled">
    												<li> 
    													<small style="color:#939598">Minimum Amount:</small>
    													<h6 class="text-white">$10,000</h6>
    												</li>
    												<li> 
    													<small style="color:#939598">Maximum Amount:</small>
    													<h6 class="text-white">$1,000,000</h6>
    												</li>
    												<!--<li>-->
    												<!--	<small style="color:#939598">ROI:</small>-->
    												<!--	<h6 class="text-white">0% - 0%</h6>-->
    												<!--</li>-->
    												<li class="mb-0">
    													<small style="color:#939598">Returns:</small>
    													<h6 class="text-white">45%+</h6>
    												</li>
    											</ul>
    											<hr class="my-4 divider divider-fade divider-dark w-100" />
    											                									<!-- Button -->
                									<div class="mt-5">
                										<form method="post" action="deposit.php">
															<input type="hidden" name="csrfmiddlewaretoken" value="cSkA4SpW0W8j4AtPINM4ooPrCjfa5fRYlTUXMqkWYG1x8Tianfz96muT4O1ps24Z">
                											<h6 class="text-white">Amount to invest</h6>
															<input type="number" class="form-control" name="amount" step="any" value="10000" >
                                                          <input type="hidden" class="btn btn btn-neutral w-100" name="plan" value="Premium" >
                											<input type="submit" class="btn btn btn-neutral w-100" name="" value="Invest" >
                										</form>
                									</div>
                								    											<!---->
    											<!--	<form action='' method="POST">-->
    											<!--		<input type="hidden" name="_token" value="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">-->
    											<!--		<div class="form-group">-->
    											<!--			<input type="hidden" value="" name="method">-->
    											<!--			<button class="mb-3 btn btn-sm btn-neutral" type='submit'><i-->
    											<!--					class="fa fa-plus"></i> Request withdrawal</button>-->
    											<!--		</div>-->
    											<!--	</form>-->
    											<!---->
    										</div>
    									</div>
    								</div>
                                </div>
                                                            <div class="mb-4 col-lg-4">
    								<div class="card-deck">
    									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
    										<!--<div class="py-0 border-0 card-header">-->
    										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">BASIC</span>-->
    										<!--</div>-->
    										<div class="card-body">
    										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Premium +</small>
    										    <hr class="my-4 divider divider-fade divider-dark w-100" />
    											<ul class="text-white list-unstyled">
    												<li> 
    													<small style="color:#939598">Minimum Amount:</small>
    													<h6 class="text-white">$50,000</h6>
    												</li>
    												<li> 
    													<small style="color:#939598">Maximum Amount:</small>
    													<h6 class="text-white">$300,000</h6>
    												</li>
    												<!--<li>-->
    												<!--	<small style="color:#939598">ROI:</small>-->
    												<!--	<h6 class="text-white">0% - 0%</h6>-->
    												<!--</li>-->
    												<li class="mb-0">
    													<small style="color:#939598">Duration:</small>
    													<h6 class="text-white"</h6>
    												</li>
    											</ul>
    											<hr class="my-4 divider divider-fade divider-dark w-100" />
    											                									<!-- Button -->
                									<div class="mt-5">
                										<form method="post" action="deposit.php">
															<input type="hidden" name="csrfmiddlewaretoken" value="cSkA4SpW0W8j4AtPINM4ooPrCjfa5fRYlTUXMqkWYG1x8Tianfz96muT4O1ps24Z">
                											<h6 class="text-white">Amount to invest</h6>
															<input type="number" class="form-control" name="amount" step="any" value="50000" >
                                                          <input type="hidden" class="btn btn btn-neutral w-100" name="plan" value="Premium+" >
                											<input type="submit" class="btn btn btn-neutral w-100" name="basic" value="Invest" >
                										</form>
                									</div>
                								    											<!---->
    											<!--	<form action='' method="POST">-->
    											<!--		<input type="hidden" name="_token" value="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">-->
    											<!--		<div class="form-group">-->
    											<!--			<input type="hidden" value="" name="method">-->
    											<!--			<button class="mb-3 btn btn-sm btn-neutral" type='submit'><i-->
    											<!--					class="fa fa-plus"></i> Request withdrawal</button>-->
    											<!--		</div>-->
    											<!--	</form>-->
    											<!---->
    										</div>
    									</div>
    								</div>
                                </div>
                                                            <!---->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    
</div>
<!-- Livewire Component wire-end:NeI9c1hbwQ9j1vocqzXG -->                </div>
            </div>
        </div>
	</div>

            </div>
            <?php include('footer.php'); ?>
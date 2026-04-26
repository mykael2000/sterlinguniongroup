<?php include('header.php'); ?>


            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Make a Tranfer</h5>
            </div>
        </div>
    </div>
    <div>
    </div>    <div>
    </div>    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="my-2 row d-flex nowrap">
                                                  
                                                    <div class="mb-4 col-lg-4">
								<div class="card-deck">
									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
										<!--<div class="py-0 border-0 card-header">-->
										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">USDT</span>-->
											<!--<div class="py-5">-->
											<!--	<img src="img/svg/illustrations/method.svg" alt="withdrawal method image" srcset="" class="img-fluid img-center" style="height:90px;">-->
												
											<!--</div>-->
										<!--</div>-->
										<!--<hr class="my-0 divider divider-fade divider-dark" />-->
										<div class="card-body">
										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">USDT</small>
										    <hr class="my-4 divider divider-fade divider-dark w-100" />
											<ul class="mb-4 text-white list-unstyled">
												<li> 
													<small style="color:#939598">Minimum Amount:</small>
													<h6 class="text-white">$100</h6>
												</li>
												<li>
													<small style="color:#939598">Maximum Amount:</small>
													<h6 class="text-white">$100,000</h6>
												</li>
												<!--<li>-->
												<!--    <small style="color:#939598">Charge Type:</small>-->
												<!--	<p class="text-white h5">percentage</p>-->
												<!--</li>-->
												<!--<li>-->
												<!--    <small style="color:#939598">Withdrawal Charges:</small>-->
												<!--	<h6 class="text-white">-->
												<!--	    	-->
												<!--			0%-->
												<!--		-->
												<!--	</h6>-->
												<!--</li>-->
												<!--<li>-->
												<!--	Duration: <strong></strong>-->
												<!--</li>-->
											</ul>
											<hr class="my-4 divider divider-fade divider-dark w-100" />
												<form action='process_withdrawal.php' method="POST">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="QlWtr0UEsqtrnWFVkEMwjkq4dfXGaANbZmwQ9yPEqamFrfugZ6zB1i5wFKJVxn0c">
                                                    <div class="form-group">
														<input type="hidden" value="USDT" name="method">
														<button class="mb-3 btn btn-neutral" name="withdraw" type='submit'>Request Withdrawal</button>
													</div>
												</form>
																					</div>
									</div>
								</div>
                            </div>
                                                 
                                                    <div class="mb-4 col-lg-4">
								<div class="card-deck">
									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
										<!--<div class="py-0 border-0 card-header">-->
										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">Ethereum</span>-->
											<!--<div class="py-5">-->
											<!--	<img src="img/svg/illustrations/method.svg" alt="withdrawal method image" srcset="" class="img-fluid img-center" style="height:90px;">-->
												
											<!--</div>-->
										<!--</div>-->
										<!--<hr class="my-0 divider divider-fade divider-dark" />-->
										<div class="card-body">
										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Ethereum</small>
										    <hr class="my-4 divider divider-fade divider-dark w-100" />
											<ul class="mb-4 text-white list-unstyled">
												<li> 
													<small style="color:#939598">Minimum Amount:</small>
													<h6 class="text-white">$100</h6>
												</li>
												<li>
													<small style="color:#939598">Maximum Amount:</small>
													<h6 class="text-white">$100,000</h6>
												</li>
												<!--<li>-->
												<!--    <small style="color:#939598">Charge Type:</small>-->
												<!--	<p class="text-white h5">percentage</p>-->
												<!--</li>-->
												<!--<li>-->
												<!--    <small style="color:#939598">Withdrawal Charges:</small>-->
												<!--	<h6 class="text-white">-->
												<!--	    	-->
												<!--			0%-->
												<!--		-->
												<!--	</h6>-->
												<!--</li>-->
												<!--<li>-->
												<!--	Duration: <strong></strong>-->
												<!--</li>-->
											</ul>
											<hr class="my-4 divider divider-fade divider-dark w-100" />
												<form action='process_withdrawal.php' method="POST">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="QlWtr0UEsqtrnWFVkEMwjkq4dfXGaANbZmwQ9yPEqamFrfugZ6zB1i5wFKJVxn0c">
                                                    <div class="form-group">
														<input type="hidden" value="Ethereum" name="method">
														<button class="mb-3 btn btn-neutral" name="withdraw" type='submit'>Request Withdrawal</button>
													</div>
												</form>
																					</div>
									</div>
								</div>
                            </div>
                                                    <div class="mb-4 col-lg-4">
								<div class="card-deck">
									<div class="text-center border-0 rounded-lg shadow-lg card card-pricing hover-scale-50 bg-primary popular">
										<!--<div class="py-0 border-0 card-header">-->
										<!--	<span class="px-4 py-1 mx-auto bg-white shadow-sm h6 d-inline-block rounded-bottom">Bitcoin</span>-->
											<!--<div class="py-5">-->
											<!--	<img src="img/svg/illustrations/method.svg" alt="withdrawal method image" srcset="" class="img-fluid img-center" style="height:90px;">-->
												
											<!--</div>-->
										<!--</div>-->
										<!--<hr class="my-0 divider divider-fade divider-dark" />-->
										<div class="card-body">
										    <small class="text-white" style="font-size:0.9rem !important; text-transform:uppercase">Bitcoin</small>
										    <hr class="my-4 divider divider-fade divider-dark w-100" />
											<ul class="mb-4 text-white list-unstyled">
												<li> 
													<small style="color:#939598">Minimum Amount:</small>
													<h6 class="text-white">$100</h6>
												</li>
												<li>
													<small style="color:#939598">Maximum Amount:</small>
													<h6 class="text-white">$100,000</h6>
												</li>
												<!--<li>-->
												<!--    <small style="color:#939598">Charge Type:</small>-->
												<!--	<p class="text-white h5">percentage</p>-->
												<!--</li>-->
												<!--<li>-->
												<!--    <small style="color:#939598">Withdrawal Charges:</small>-->
												<!--	<h6 class="text-white">-->
												<!--	    	-->
												<!--			0%-->
												<!--		-->
												<!--	</h6>-->
												<!--</li>-->
												<!--<li>-->
												<!--	Duration: <strong></strong>-->
												<!--</li>-->
											</ul>
											<hr class="my-4 divider divider-fade divider-dark w-100" />
												<form action='process_withdrawal.php' method="POST">
                                                    <input type="hidden" name="csrfmiddlewaretoken" value="QlWtr0UEsqtrnWFVkEMwjkq4dfXGaANbZmwQ9yPEqamFrfugZ6zB1i5wFKJVxn0c">
                                                    <div class="form-group">
														<input type="hidden" value="Bitcoin" name="method">
														<button class="mb-3 btn btn-neutral" name="withdraw" type='submit'>Request Withdrawal</button>
													</div>
												</form>
																					</div>
									</div>
								</div>
                            </div>
                                            </div>
                    <!-- Withdrawal Modal -->
                    <div id="withdrawdisabled" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h6 class="modal-title">Withdrawal Status</h6>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
                                </div>
                                <div class="modal-body ">
                                    <h6 class="">Withdrawal is Disabled at the moment, Please check
                                        back later</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Withdrawals Modal -->
                </div>
            </div>

        </div>
    </div>
            </div>
            <?php include('footer.php'); ?>
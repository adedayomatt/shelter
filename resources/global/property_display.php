	<div class="<?php echo (isset($property_display_blocking) ? $property_display_blocking : "col-lg-6 col-md-6 col-sm-12 col-xs-12")?>">	
		<div class="white-background margin-4-2  white-background" onMouseEnter="javascript: this.querySelector('.rent-figure').setAttribute('class','rent-figure animate pulse red-background')" onMouseLeave="javascript: this.querySelector('.rent-figure').setAttribute('class','rent-figure animate bounce site-color-background')">
				<div class="padding-5">
				<div class="row">
					<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
						<a href="<?php echo $tool->relative_url().$property->url ?>" class="site-color font-20 bold" style="line-height:25px" ><?php echo $tool->substring($property->type,'abc',15) ?></a>
					</span>
					<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="padding:10px 0px">
						<span class="animate bounce rent-figure site-color-background">N <?php echo number_format($property->rent) ?></span>		
					</span>
				</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="animate-in-2s animate-infinite flash text-center white full-width padding-5 margin-5-0 font-20 absolute" style="height:40px"> <span class=" padding-5 border-radius-5 white <?php echo ($property->status == 'Available' ? 'green-background' : 'black-background') ?>"><?php echo $property->status ?></span> </div>
						<img class="recently-added-dp property-images" src="<?php echo $property->display_photo_url() ?>" <?php echo $property->image_attributes($popup = true) ?>/>
				<div class="other-images-container visible-lg visible-md visible-sm hidden-xs">
				<?php
					$all_images = $property->photos();
					if(count($all_images) >= 1){
					?>
					<div class="row ">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php 
						for($i=0; $i<count($all_images); ++$i){
							if($all_images[$i] == $property->display_photo_url()){
								//skip the display picture
								continue;
							}
							if($i >=3){
								break;
							}
						?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="margin-1">
									<img class="recently-added-other-images property-images"   src="<?php echo $all_images[$i] ?>" <?php echo $property->image_attributes($popup = true) ?>/>
								</div>
							</div>
						<?php
						}
						?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
								<div class="operation-report-container success">
									<span class="glyphicon glyphicon-picture"></span> <?php echo count($all_images) ?> total images available
								</div>
							</div>

					</div>
					</div>
					<?php
					}
					else{
						?>
						<div class="operation-report-container fail">
							<span class="glyphicon glyphicon-picture"></span> No Photo is available for this property
						</div>
						<?php
					}
					?>	
					</div>
					<div class="padding-5 visible-lg visible-md visible-sm hidden-xs">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
								<?php
											if(($status == 1) && ($property->agent_business_name == $loggedIn_agent->business_name)){
												?>
												<span class=""><a href="<?php echo "$root/manage/property.php?id=".$property->id."&action=change&agent=".$property->agent_token ?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>  update this property</a></span>
												<?php
											}
											else{
											?>
											<a class="btn btn-default" tabindex="0" role="link" data-toggle="popover" data-trigger="hover click" data-placement="top" data-html="true"  title="<h3><?php echo $property->agent_business_name ?></h3>"
											data-content="<div><span class='glyphicon glyphicon-map-marker site-color'></span><?php echo $property->agent_address ?><ul class='agent-contacts-list'><li><span class='glyphicon glyphicon-phone-alt site-color'></span><?php echo $property->agent_office_contact ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $property->agent_contact1 ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $property->agent_contact2 ?></li></ul><div><a href='<?php echo $root.'/agents/'.$property->agent_username ?>' > Go to profile »</a><p>view profile to see other properties by <?php echo $property->agent_business_name ?></p></div></div>">
											<span class="glyphicon glyphicon-briefcase"></span> <?php echo $tool->substring($property->agent_business_name,'abc',15) ?>
											</a>
											<?php
											}
											?>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
								<span title="this property have been viewed <?php echo $property->views ?> times" class="site-color"><span class="glyphicon glyphicon-eye-open"></span><?php echo $property->views ?></span>
							</div>
						</div>
						</div>						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="property-detail-wrapper">
							<div class="padding-10">
								<div title="<?php echo $property->location ?>" class="padding-5 margin-2-0  f7-background border-radius-5 e3-border"><span class="glyphicon glyphicon-map-marker site-color site-color-border round"></span><?php echo $tool->substring($property->location,'abcxyz',30) ?></div>
								<div class="padding-5 margin-2-0 f7-background border-radius-5  e3-border"><span class="glyphicon glyphicon-exclamation-sign site-color site-color-border round"></span><strong><?php echo $property->min_payment ?></strong> payment required (N <?php echo ($property->min_payment == '1 year, 6months' ?  $property->rent + (0.5 * $property->rent) : ($property->min_payment == '2 years' ?  2 * $property->rent : $property->rent)) ?>)</div>
								<div class="padding-5 margin-2-0  f7-background border-radius-5  e3-border">
								<div class="row text-center">
									<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6  font-12"><?php echo  $property->bath ?> Bath(s) </span>
									<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6  font-12"><?php echo  $property->loo ?> Toilets(s) <span>
								</div>
								</div>
								<div class="padding-5 margin-2-0 f7-background border-radius-5  e3-border"><span class="glyphicon glyphicon-time site-color site-color-border round"></span><?php echo $tool->since($property->upload_timestamp) ?></div>
								<div class="padding-5 margin-2-0  f7-background border-radius-5  e3-border"><span class="glyphicon glyphicon-calendar site-color site-color-border round"></span><?php echo 'updated '.$tool->since($property->last_reviewed) ?></div>
								<div class="padding-5">
									<div class="row hidden-lg hidden-md hidden-sm visible-xs">
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
											<?php
											if(($status == 1) && ($property->agent_business_name == $loggedIn_agent->business_name)){
												?>
												<span class=""><a href="<?php echo "$root/manage/property.php?id=".$property->id."&action=change&agent=".$property->agent_token ?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>  update this property</a></span>
												<?php
											}
											else{
											?>
											<a class="btn btn-default" tabindex="0" role="link" data-toggle="popover" data-trigger="hover click" data-placement="top" data-html="true"  title="<h3><?php echo $property->agent_business_name ?></h3>"
											data-content="<div><span class='glyphicon glyphicon-map-marker site-color'></span><?php echo $property->agent_address ?><ul class='agent-contacts-list'><li><span class='glyphicon glyphicon-phone-alt site-color'></span><?php echo $property->agent_office_contact ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $property->agent_contact1 ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $property->agent_contact2 ?></li></ul><div><a href='<?php echo $root.'/agents/'.$property->agent_username ?>' > Go to profile »</a><p>view profile to see other properties by <?php echo $property->agent_business_name ?></p></div></div>">
											<span class="glyphicon glyphicon-briefcase"></span> <?php echo $tool->substring($property->agent_business_name,'abc',15) ?>
											</a>
											<?php
											}
											?>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
											<span title="this property have been viewed <?php echo $property->views ?> times" class="site-color"><span class="glyphicon glyphicon-eye-open"></span><?php echo $property->views ?></span>
										</div>
									</div>
								</div>
							<div class="row text-center">
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<span><?php echo ($status == 9 ? $property->clip_button($loggedIn_client->id,$loggedIn_client->token,$ref) : $property->clip_button(null,null,$ref)) ?></span>
								</span>
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
									<span ><a  class="site-color" title="see full information about this <?php echo $property->type ?>"  href="<?php echo "$root/".$property->url ?>"><span class="glyphicon glyphicon-link"></span> See Details</a></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
<?php unset($property) ?>

	
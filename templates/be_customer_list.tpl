<?php $lang = $this->lang; ?>
<div id="tl_buttons">
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['customerNew'][1]; ?>"
	   class="header_new customer" href="contao/main.php?do=member&amp;act=create">
        <?php echo $lang['customerNew'][0]; ?>
    </a> :: 
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['projectNew'][1]; ?>"
	   class="header_new project" href="contao/main.php?do=li_customers&amp;table=tl_li_project&amp;act=create">
        <?php echo $lang['projectNew'][0]; ?>
    </a> :: 
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['serviceNew'][1]; ?>"
	   class="header_new service" href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=create">
        <?php echo $lang['serviceNew'][0]; ?>
    </a> :: 
    <a onclick="Backend.getScrollOffset();" accesskey="n" title="<?php echo $lang['productNew'][1]; ?>"
	   class="header_new product" href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=create">
        <?php echo $lang['productNew'][0]; ?>
    </a>
</div>
<?php if(count($this->customers)) : ?>
    <div id="tl_listing" class="tl_listing_container tree_view">
        <ul class="tl_listing tl_tree">
            
            <li class="tl_folder_top">
                <div class="tl_left">
                    <img height="16" width="16" alt="" src="system/modules/li_crm/icons/customers.png" /> 
                    <label><?php echo $lang['customers']; ?></label>
                </div>
                <div class="tl_right">&nbsp;</div>
                <div style="clear:both;"></div>
            </li>
            <?php foreach($this->customers as $customer) : ?>
                <li id="customer_<?php echo $customer['customerNumber']; ?>"
					class="tl_folder customer<?php echo $customer['isDisabled'] ? " disabled" : ""; ?>"
					onmouseout="Theme.hoverDiv(this, 0);" onmouseover="Theme.hoverDiv(this, 1);">
                    <div class="tl_left">
						<?php if (count($customer['projects']) > 0): ?>
							<a href="contao/main.php?do=li_customers&amp;toggle=customer&amp;id=<?php echo $customer['id']; ?>">
								<?php if ($customer['display']): ?>
									<img src="system/themes/default/images/folMinus.gif" />
								<?php else: ?>
									<img src="system/themes/default/images/folPlus.gif" />
								<?php endif; ?>
							</a> 
						<?php else: ?>
							<span style="padding-left: 22px;"></span>
						<?php endif; ?>
                        <?php if(!$customer['isDisabled']): ?>
                            <span>
								<img class="icon" height="16" width="16" alt="<?php echo $lang['customer']; ?>"
									 src="system/modules/li_crm/icons/customer.png" />
							</span>
                        <?php else : ?>
                            <span>
								<img class="icon" height="16" width="16" alt="<?php echo $lang['customer']; ?>"
									 src="system/modules/li_crm/icons/customer_disabled.png" />
							</span>
                        <?php endif; ?>
                        <strong>
							<?php echo $customer['customerNumber']." ".$customer['customerName']; ?>
						</strong>
                    </div>
                    <div class="tl_right">
                        <a href="contao/main.php?do=member&amp;act=edit&amp;id=<?php echo $customer['id']; ?>"
							title="<?php echo $customer['editTitle']; ?>"><img src="system/themes/default/images/edit.gif"
							alt="<?php echo $customer['editLabel']; ?>" width="12" height="16" />
						</a> 
                        <?php if(!$customer['isDisabled']) : ?>
                            <a href="contao/main.php?do=member&amp;act=copy&amp;id=<?php echo $customer['id']; ?>"
							   title="<?php echo $customer['copyTitle']; ?>"><img src="system/themes/default/images/copy.gif"
								alt="<?php echo $customer['copyLabel']; ?>" width="14" height="16" />
							</a> 
                            <a href="contao/main.php?do=member&amp;act=delete&amp;id=<?php echo $customer['id']; ?>"
								title="<?php echo $customer['deleteTitle']; ?>"
								onclick="if (!confirm('<?php echo $customer['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
								<img src="system/themes/default/images/delete.gif"
									 alt="<?php echo $customer['deleteLabel']; ?>" width="14" height="16" />
							</a> 
                        <?php else : ?>
                            <span>
								<img src="system/themes/default/images/copy_.gif"
									alt="<?php echo $customer['copyLabel']; ?>" width="14" height="16" />
							</span> 
                            <span>
								<img src="system/themes/default/images/delete_.gif"
									alt="<?php echo $customer['deleteLabel']; ?>" width="14" height="16" />
							</span> 
                        <?php endif; ?>
                        <a href="contao/main.php?do=member&amp;act=show&amp;id=<?php echo $customer['id']; ?>"
						   title="<?php echo $customer['infoTitle']; ?>">
							<img src="system/themes/default/images/show.gif"
								alt="<?php echo $customer['infoLabel']; ?>" width="14" height="16" />
						</a> 
                        <a title="<?php echo $customer['contactsTitle']; ?>"
						   href="contao/main.php?do=member&amp;table=tl_li_contact&amp;id=<?php echo $customer['id'] ?>">
							<img height="16" width="16" alt="<?php echo $customer['contactsLabel']; ?>"
								src="system/modules/li_crm/icons/contacts.png" />
						</a> 
                        <a title="<?php echo $customer['addressesTitle']; ?>"
						   href="contao/main.php?do=member&amp;table=tl_address&amp;id=<?php echo $customer['id'] ?>">
							<img height="16" width="16" alt="<?php echo $customer['addressesLabel']; ?>"
								src="system/modules/addresses/icons/addressbook.png" />
						</a>
                    </div>
                    <div style="clear:both;"></div>
                </li>
				<?php if ($customer['display']): ?>
                    <?php foreach($customer['services'] as $service) : ?>
                        <li class="tl_file simpleService" style="" onmouseout="Theme.hoverDiv(this, 0);"
                            onmouseover="Theme.hoverDiv(this, 1);">
                            <div class="tl_left">
                                <span>
                                    <img class="icon" height="16" width="16"
                                         alt="<?php echo $service['serviceTitle']; ?>"
                                         src="<?php echo $service['icon']; ?>" />
                                </span>
                                <span><?php echo $service['serviceTitle']; ?></span>
                            </div>
                            <div class="tl_right">
                                <?php if(!$customer['isDisabled']) : ?>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=edit&amp;id=<?php echo $service['id']; ?>"
                                        title="<?php echo $service['editTitle']; ?>">
                                        <img src="system/themes/default/images/edit.gif"
                                            alt="<?php echo $service['editLabel']; ?>" width="12" height="16" />
                                    </a>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=copy&amp;id=<?php echo $service['id']; ?>"
                                        title="<?php echo $service['copyTitle']; ?>">
                                        <img src="system/themes/default/images/copy.gif"
                                            alt="<?php echo $service['copyLabel']; ?>" width="14" height="16" />
                                    </a>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=delete&amp;id=<?php echo $service['id']; ?>"
                                       title="<?php echo $service['deleteTitle']; ?>"
                                       onclick="if (!confirm('<?php echo $service['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
                                        <img src="system/themes/default/images/delete.gif"
                                             alt="<?php echo $service['deleteLabel']; ?>" width="14" height="16" />
                                    </a>
                                <?php else: ?>
                                    <span>
                                        <img src="system/themes/default/images/delete_.gif"
                                               alt="<?php echo $service['deleteLabel']; ?>" width="14" height="16" />
                                    </span>
                                <?php endif; ?>
                                <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=show&amp;id=<?php echo $service['id']; ?>"
                                   title="<?php echo $service['infoTitle']; ?>">
                                    <img src="system/themes/default/images/show.gif"
                                         alt="<?php echo $service['infoLabel']; ?>" width="14" height="16" />
                                </a>
                            </div>
                            <div style="clear:both;"></div>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach($customer['products'] as $product): ?>
                        <li class="tl_file simpleProduct" style="" onmouseout="Theme.hoverDiv(this, 0);"
                            onmouseover="Theme.hoverDiv(this, 1);">
                            <div class="tl_left">
                                <span>
                                    <img class="icon" height="16" width="16"
                                         alt="<?php echo $product['productTitle']; ?>"
                                         src="<?php echo $product['icon']; ?>" />
                                </span>
                                <span><?php echo $product['productTitle']; ?></span>
                            </div>
                            <div class="tl_right">
                                <?php if(!$customer['isDisabled']) : ?>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=edit&amp;id=<?php echo $product['id']; ?>"
                                        title="<?php echo $product['editTitle']; ?>">
                                        <img src="system/themes/default/images/edit.gif"
                                            alt="<?php echo $product['editLabel']; ?>" width="12" height="16" />
                                    </a>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=copy&amp;id=<?php echo $product['id']; ?>"
                                       title="<?php echo $product['copyTitle']; ?>">
                                        <img src="system/themes/default/images/copy.gif"
                                             alt="<?php echo $product['copyLabel']; ?>" width="14" height="16" />
                                    </a>
                                    <a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=delete&amp;id=<?php echo $product['id']; ?>"
                                       title="<?php echo $product['deleteTitle']; ?>"
                                       onclick="if (!confirm('<?php echo $product['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
                                        <img src="system/themes/default/images/delete.gif"
                                             alt="<?php echo $product['deleteLabel']; ?>" width="14" height="16" />
                                    </a>
                                <?php else: ?>
                                    <span>
                                        <img src="system/themes/default/images/edit_.gif"
                                               alt="<?php echo $product['editLabel']; ?>" width="14" height="16" />
                                    </span>
                                    <span>
                                        <img src="system/themes/default/images/copy_.gif"
                                               alt="<?php echo $product['copyLabel']; ?>" width="14" height="16" />
                                    </span>
                                    <span>
                                        <img src="system/themes/default/images/delete_.gif"
                                               alt="<?php echo $product['deleteLabel']; ?>" width="14" height="16" />
                                    </span>
                                <?php endif; ?>
                                <a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=show&amp;id=<?php echo $product['id']; ?>"
                                   title="<?php echo $product['infoTitle']; ?>">
                                    <img src="system/themes/default/images/show.gif"
                                         alt="<?php echo $product['infoLabel']; ?>" width="14" height="16" />
                                </a>
                            </div>
                            <div style="clear:both;"></div>
                        </li>
                    <?php endforeach; ?>
					<?php foreach($customer['projects'] as $project) : ?>
						<li class="tl_file project" style="" onmouseout="Theme.hoverDiv(this, 0);"
							onmouseover="Theme.hoverDiv(this, 1);">
							<div class="tl_left">
								<?php if (count($project['services']) > 0 || count($project['products']) > 0): ?>
									<a href="contao/main.php?do=li_customers&amp;toggle=project&amp;id=<?php echo $project['id']; ?>">
										<?php if ($project['display'] && (count($project['services']) > 0 || count($project['products']) > 0)): ?>
											<img src="system/themes/default/images/folMinus.gif" /> 
										<?php else: ?>
											<img src="system/themes/default/images/folPlus.gif" /> 
										<?php endif; ?>
									</a>
								<?php else: ?>
									<span style="padding-left: 22px;"></span>
								<?php endif; ?>
								<span><img class="icon" height="16" width="16" alt="" src="system/modules/li_crm/icons/projects.png" /> </span>
								<em><?php echo $project['projectNumber']; ?> - <?php echo $project['title']; ?></em>
							</div>
							<div class="tl_right">
								<?php if(!$customer['isDisabled']) : ?>
									<a href="contao/main.php?do=li_customers&amp;table=tl_li_project&amp;act=edit&amp;id=<?php echo $project['id']; ?>"
										title="<?php echo $project['editTitle']; ?>">
										<img src="system/themes/default/images/edit.gif"
											alt="<?php echo $project['editLabel']; ?>" width="12" height="16" />
									</a> 
									<a href="contao/main.php?do=li_customers&amp;table=tl_li_project&amp;act=copy&amp;id=<?php echo $project['id']; ?>"
										title="<?php echo $project['copyTitle']; ?>">
										<img src="system/themes/default/images/copy.gif"
											alt="<?php echo $project['copyLabel']; ?>" width="14" height="16" />
									</a> 
									<a href="contao/main.php?do=li_customers&amp;table=tl_li_project&amp;act=delete&amp;id=<?php echo $project['id']; ?>"
										title="<?php echo $project['deleteTitle']; ?>"
										onclick="if (!confirm('<?php echo $project['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
										<img src="system/themes/default/images/delete.gif"
											alt="<?php echo $project['deleteLabel']; ?>" width="14" height="16" />
									</a> 
								<?php else: ?>
									<span>
										<img src="system/themes/default/images/edit_.gif"
											alt="<?php echo $project['editLabel']; ?>" width="12" height="16" />
									</span> 
									<span>
										<img src="system/themes/default/images/copy_.gif"
											alt="<?php echo $project['copyLabel']; ?>" width="14" height="16" />
									</span> 
									<span>
										<img src="system/themes/default/images/delete_.gif"
											alt="<?php echo $project['deleteLabel']; ?>" width="14" height="16" />
									</span> 
								<?php endif; ?>
								<a href="contao/main.php?do=li_customers&amp;table=tl_li_project&amp;act=show&amp;id=<?php echo $project['id']; ?>"
									title="<?php echo $project['infoTitle']; ?>">
									<img src="system/themes/default/images/show.gif"
										alt="<?php echo $project['infoLabel']; ?>" width="14" height="16" />
								</a>
							</div>
							<div style="clear:both;"></div>
						</li>
						<?php if ($project['display']): ?>
							<?php foreach($project['services'] as $service) : ?>
								<li class="tl_file service" style="" onmouseout="Theme.hoverDiv(this, 0);"
									onmouseover="Theme.hoverDiv(this, 1);">
									<div class="tl_left">
										<span>
											<img class="icon" height="16" width="16"
												 alt="<?php echo $service['serviceTitle']; ?>"
												 src="<?php echo $service['icon']; ?>" />
										</span>
										<span><?php echo $service['serviceTitle']; ?></span>
									</div>
									<div class="tl_right">
										<?php if(!$customer['isDisabled']) : ?>
                                            <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=edit&amp;id=<?php echo $service['id']; ?>"
                                                title="<?php echo $service['editTitle']; ?>">
                                                <img src="system/themes/default/images/edit.gif"
                                                    alt="<?php echo $service['editLabel']; ?>" width="12" height="16" />
                                            </a>
                                            <a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=copy&amp;id=<?php echo $service['id']; ?>"
                                                title="<?php echo $service['copyTitle']; ?>">
                                                <img src="system/themes/default/images/copy.gif"
                                                    alt="<?php echo $service['copyLabel']; ?>" width="14" height="16" />
                                            </a>
											<a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=delete&amp;id=<?php echo $service['id']; ?>"
											   title="<?php echo $service['deleteTitle']; ?>"
											   onclick="if (!confirm('<?php echo $service['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
												<img src="system/themes/default/images/delete.gif"
													 alt="<?php echo $service['deleteLabel']; ?>" width="14" height="16" />
											</a>
										<?php else: ?>
											<span>
												<img src="system/themes/default/images/delete_.gif"
													   alt="<?php echo $service['deleteLabel']; ?>" width="14" height="16" />
											</span>
										<?php endif; ?>
										<a href="contao/main.php?do=li_customers&amp;table=tl_li_service&amp;act=show&amp;id=<?php echo $service['id']; ?>"
										   title="<?php echo $service['infoTitle']; ?>">
											<img src="system/themes/default/images/show.gif"
												 alt="<?php echo $service['infoLabel']; ?>" width="14" height="16" />
										</a>
									</div>
									<div style="clear:both;"></div>
								</li>
							<?php endforeach; ?>
                            <?php foreach($project['products'] as $product): ?>
								<li class="tl_file product" style="" onmouseout="Theme.hoverDiv(this, 0);"
									onmouseover="Theme.hoverDiv(this, 1);">
									<div class="tl_left">
										<span>
											<img class="icon" height="16" width="16"
												 alt="<?php echo $product['productTitle']; ?>"
												 src="<?php echo $product['icon']; ?>" />
										</span> 
										<span><?php echo $product['productTitle']; ?></span>
									</div>
									<div class="tl_right">
										<?php if(!$customer['isDisabled']) : ?>
                                            <a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=edit&amp;id=<?php echo $product['id']; ?>"
                                                title="<?php echo $product['editTitle']; ?>">
                                                <img src="system/themes/default/images/edit.gif"
                                                    alt="<?php echo $product['editLabel']; ?>" width="12" height="16" />
                                            </a> 
											<a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=copy&amp;id=<?php echo $product['id']; ?>"
											   title="<?php echo $product['copyTitle']; ?>">
												<img src="system/themes/default/images/copy.gif"
													 alt="<?php echo $product['copyLabel']; ?>" width="14" height="16" />
											</a> 
											<a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=delete&amp;id=<?php echo $product['id']; ?>"
											   title="<?php echo $product['deleteTitle']; ?>"
											   onclick="if (!confirm('<?php echo $product['deleteDialog']; ?>')) return false; Backend.getScrollOffset();">
												<img src="system/themes/default/images/delete.gif"
													 alt="<?php echo $product['deleteLabel']; ?>" width="14" height="16" />
											</a> 
										<?php else: ?>
											<span>
												<img src="system/themes/default/images/edit_.gif"
													   alt="<?php echo $product['editLabel']; ?>" width="14" height="16" />
											</span> 
											<span>
												<img src="system/themes/default/images/copy_.gif"
													   alt="<?php echo $product['copyLabel']; ?>" width="14" height="16" />
											</span> 
											<span>
												<img src="system/themes/default/images/delete_.gif"
													   alt="<?php echo $product['deleteLabel']; ?>" width="14" height="16" />
											</span> 
										<?php endif; ?>
										<a href="contao/main.php?do=li_customers&amp;table=tl_li_product_to_customer&amp;act=show&amp;id=<?php echo $product['id']; ?>"
										   title="<?php echo $product['infoTitle']; ?>">
											<img src="system/themes/default/images/show.gif"
												 alt="<?php echo $product['infoLabel']; ?>" width="14" height="16" />
										</a>
									</div>
									<div style="clear:both;"></div>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else : ?>
    <p class="tl_empty"><?php echo $lang['noEntries']; ?></p>
<?php endif; ?>
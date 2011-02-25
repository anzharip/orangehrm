<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css')?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js')?>"></script>
<?php echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php echo javascript_include_tag('orangehrm.datepicker.js')?>
<script type="text/javascript">
    //<![CDATA[
    var lang_numberRequired = "<?php echo __('Document number is required');?>";
    var lang_issueDateRequired = "<?php echo __('Issued date is required'); ?>";
    var lang_expireDateRequired = "<?php echo __('Expiry date is required');?>";
    var lang_countryRequired = "<?php echo __('Country is required');?>";
    var lang_reviewDateRequired = "<?php echo __('Review date required');?>";
    //]]>
</script>

<?php echo stylesheet_tag('../orangehrmPimPlugin/css/viewPersonalDetailsSuccess'); ?>
<?php echo javascript_include_tag('../orangehrmPimPlugin/js/viewImmigrationSuccess'); ?>
<!-- common table structure to be followed -->
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td width="5">&nbsp;</td>
        <td colspan="2" height="30">&nbsp;<?php if($showBackButton) {?><input type="button" class="backbutton" value="<?php echo __("Back") ?>" onclick="goBack();" /><?php }?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <!-- this space is reserved for menus - dont use -->
        <td width="200" valign="top"><?php include_partial('leftmenu', array('empNumber' => $empNumber));?></td>
        <td valign="top">
            <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td valign="top">
                        <!-- this space is for contents -->
                        <div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" style="margin-left: 16px;width: 630px;">
                            <span style="font-weight: bold;"><?php echo isset($message) ? $message : ''; ?></span>
                        </div>
                        <div class="formpage2col">
                            <div id="immigrationDataPane">
                                <div class="outerbox">
                                    <div class="mainHeading"><h2><?php echo __('Immigration'); ?></h2></div>
                                    <form name="frmEmpImmigration" id="frmEmpImmigration" method="post" action="<?php echo url_for('pim/viewImmigration'); ?>">
                                        <?php echo $form['_csrf_token']; ?>
                                        <?php echo $form['emp_number']->render();?>
                                        <?php echo $form['seqno']->render();?>
                                        <div>
                                            <?php echo $form['type_flag']->renderLabel(__('Document')); ?>
                                            <?php echo $form['type_flag']->render(); ?>
                                            <br class="clear" />

                                            <?php echo $form['number']->renderLabel(__('Number') . ' <span class="required">*</span>'); ?>
                                            <?php echo $form['number']->render(array("class" => "formInputText", "maxlength" => 20)); ?>
                                            <br class="clear" />

                                            <?php echo $form['passport_issue_date']->renderLabel(__('Issued Date') . ' <span class="required">*</span>'); ?>
                                            <?php echo $form['passport_issue_date']->render(array("class" => "formInputText")); ?>
                                            <input id="passportIssueDateBtn" type="button" name="Submit" value="  " class="calendarBtn" />
                                            <br class="clear" />

                                            <?php echo $form['passport_expire_date']->renderLabel(__('Expiry Date') . ' <span class="required">*</span>'); ?>
                                            <?php echo $form['passport_expire_date']->render(array("class" => "formInputText")); ?>
                                            <input id="passportExpireDateBtn" type="button" name="Submit" value="  " class="calendarBtn" />
                                            <br class="clear" />

                                            <?php echo $form['i9_status']->renderLabel(__('Eligible Status')); ?>
                                            <?php echo $form['i9_status']->render(array("class" => "formInputText")); ?>
                                            <br class="clear" />

                                            <?php echo $form['country']->renderLabel(__('Issued By') . ' <span class="required">*</span>'); ?>
                                            <?php echo $form['country']->render(array("class" => "formInputText")); ?>
                                            <br class="clear" />

                                            <?php echo $form['i9_review_date']->renderLabel(__('Eligible Review Date') . '<span class="required">*</span>'); ?>
                                            <?php echo $form['i9_review_date']->render(array("class" => "formInputText")); ?>
                                            <input id="i9ReviewDateBtn" type="button" name="Submit" value="  " class="calendarBtn" />
                                            <br class="clear" />

                                            <?php echo $form['comments']->renderLabel(__('Comment')); ?>
                                            <?php echo $form['comments']->render(array("class" => "formInputText")); ?>
                                            <br class="clear" />
                                        </div>
                                        <div class="formbuttons">
                                            <input type="button" class="savebutton" id="btnSave" value="<?php echo __("Save"); ?>" />
                                            <input type="button" class="savebutton" id="btnCancel" value="<?php echo __("Cancel"); ?>" />
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="outerbox" id="immidrationList">
                                <form name="frmImmigrationDelete" id="frmImmigrationDelete" method="post" action="<?php echo url_for('pim/deleteImmigration?empNumber=' . $empNumber); ?>">
                                    <div class="mainHeading"><h2><?php echo __("Assigned Immigration Documents"); ?></h2></div>

                                    <div class="actionbar" id="listActions">
                                        <div class="actionbuttons">
                                            <input type="button" id="btnAdd" value="<?php echo __("Add");?>" class="addbutton" />
                                            <input type="button" id="btnDelete" value="<?php echo __("Delete");?>" class="delbutton" />
                                        </div>
                                    </div>

                                    <table width="550" cellspacing="0" cellpadding="0" class="data-table">
                                        <thead>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><?php echo __('Document');?></td>
                                                <td><?php echo __('Document No');?></td>
                                                <td><?php echo __('Issued By');?></td>
                                                <td><?php echo __('Issued Date');?></td>
                                                <td><?php echo __('Date of Expiry');?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $empPassports = $form->empPassports;
                                            $countries = $form->countries;
                                            $row = 0;
                                            foreach ($empPassports as $passport) {
                                                $cssClass = ($row % 2) ? 'even' : 'odd'; ?>

                                            <tr class="<?php echo $cssClass;?>">
                                                <!-- we make data available in hidden fields -->
                                                <input type="hidden" id="type_flag_<?php echo $passport->seqno;?>" value="<?php echo $passport->type_flag; ?>" />
                                                <input type="hidden" id="number_<?php echo $passport->seqno;?>" value="<?php echo $passport->number; ?>" />
                                                <input type="hidden" id="passport_issue_date_<?php echo $passport->seqno;?>" value="<?php echo $passport->passport_issue_date; ?>" />
                                                <input type="hidden" id="passport_expire_date_<?php echo $passport->seqno;?>" value="<?php echo $passport->passport_expire_date; ?>" />
                                                <input type="hidden" id="i9_status_<?php echo $passport->seqno;?>" value="<?php echo $passport->i9_status; ?>" />
                                                <input type="hidden" id="country_<?php echo $passport->seqno;?>" value="<?php echo $passport->country; ?>" />
                                                <input type="hidden" id="i9_review_date_<?php echo $passport->seqno;?>" value="<?php echo $passport->i9_review_date; ?>" />
                                                <input type="hidden" id="comments_<?php echo $passport->seqno;?>" value="<?php echo $passport->comments; ?>" />

                                                <!-- end of all data hidden fields -->
                                                <td class="check"><input type='checkbox' class='checkbox' name='chkImmigration[]' value='<?php echo $passport->seqno;?>' /></td>
                                                <td><a href="javascript: fillDataToImmigrationDataPane(<?php echo $passport->seqno;?>);"><?php echo ($passport->type_flag == EmpPassPort::TYPE_PASSPORT)? __("Passport"):__("Visa");?></a></td>
                                                <td><?php echo $passport->number;?></td>
                                                <td><?php echo $countries[$passport->country];?></td>
                                                <td><?php echo $passport->passport_issue_date;?></td>
                                                <td><?php echo $passport->passport_expire_date;?></td>
                                            </tr>
                                            <?php $row++; } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            <div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk')?> <span class="required">*</span> <?php echo __('are required.')?></div>
                        </div>
                    </td>
                    <td valign="top" align="left">
                        <div id="currentImage">
                            <center>
                                <a href="../../../../lib/controllers/CentralController.php?menu_no_top=hr&id=<?php echo $empNumber;?>&capturemode=updatemode&reqcode=EMP&pane=21">
                                    <img style="width:100px; height:120px;" alt="Employee Photo" src="<?php echo url_for("pim/viewPhoto?empNumber=". $empNumber); ?>" border="0"/>
                                </a>
                                <br />
                                <span class="smallHelpText"><strong><?php echo $form->fullName; ?></strong></span>
                            </center>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
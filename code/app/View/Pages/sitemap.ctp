<div class="middels_bx">
    <div class="wrapper">
                                        <?php
                                        if ($this->Session->check('error_msg')) {
                                            echo "<div class='error_msg error_lo'><span class='span_text'>" . $this->Session->read('error_msg') . "</span></div>";
                                            $this->Session->delete("error_msg");
                                        }
                                        if ($this->Session->check('success_msg')) {
                                            echo "<div class='success_msg success_lo'><span class='span_text'>" . $this->Session->read('success_msg') . "</span></div>";
                                            $this->Session->delete("success_msg");
                                        }
                                        ?>
                                        <div class="my_name"><h1>Sitemap</h1></div>
                                        <div class="my_acc cebter">
                                            <div class="edit_boxes edit_boxesdre">
                                                <ul>
                                                    <li><?php echo $this->Html->link('Home','/',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Post a Load',array('controller'=>'jobs','action'=>'addjob'),array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Load Board',array('controller'=>'jobs','action'=>'search'),array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Employment',array('controller'=>'vacancies','action'=>'search'),array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('How it Works','/how-it-works',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Privacy Policy','/privacy_policy',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Terms and Conditions','/terms-and-condition',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Advertising','/advertising',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Links','/links',array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Search Load Jobs',array('controller'=>'jobs','action'=>'search'),array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Back Loads',array('controller'=>'loads','action'=>'search'),array('escape'=>false));?></li>
                                                    <li><?php echo $this->Html->link('Contact us','/contact-us',array('escape'=>false));?></li>
                                                 </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
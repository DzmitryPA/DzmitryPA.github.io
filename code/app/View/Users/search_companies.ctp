<div class="right_part">
            <div class="search_proiduct_bane search_proiduct_bane_industries">
                <div class="search_proiduct_bane_ing search_fomr_prod_sml">
                    <h2 class="title_of_search_proiduct_bane">Search Companies</h2>
                    <div class="search_fomr_prod ">
                        <?php echo $this->Form->create(Null, array('id' => 'companyForm')); ?>
                        <div class="search_fomr_prod_row">
                            <div class="search_fomr_prod_col">
                                <div class="kteha_inpyuts">
                                    <?php echo $this->Form->text('User.keyword', array('class' => "kteha_inpyutstxets search_leeyword", 'placeholder'=>"Keyword", 'autocomplete' => "off" )); ?>
                                </div>
                            </div>
                            <div class="search_fomr_prod_col">
                                <div class="kteha_inpyuts">
                                    <?php echo $this->Form->text('User.location', array('class' => "kteha_inpyutstxets location_leeyword", 'placeholder'=>"Zip Code/City/State/Country", 'autocomplete' => "off" )); ?>
                                </div>
                            </div>
                            <div class="search_fomr_prod_col">
                                <div class="kteha_inpyuts_select">
                                    <?php echo $this->Form->select('User.industry', $industryList, array('empty' => 'Companies Type', 'class' => "kteha_inpyutstxets")); ?>
                                </div>
                            </div>                            
                            <div class="search_fomr_prod_col search_fomr_prod_col_half">
                                <div class="search_sek_bo">
                                    <?php echo $this->Ajax->submit("Search", array('div' => false, 'url' => array('controller' => 'users', 'action' => 'searchCompanies'), 'update' => 'listID', 'indicator' => 'loaderID', 'class' => 'ser_vbtn_so')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            
            <div class="m_content" id="listID">
                <?php echo $this->element("users/companies"); ?>
            </div>
            
            
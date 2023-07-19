<div class="thankk_u dashboard_page_content cntct_cntn" style="text-align:center;">
    <div class="dsvgs_thank" style="display:block; margin-top:30px;"><h2>
        <?php
                        if ($this->Session->check('reset_error_msg')) {
                            echo "<div class='error_msg error_lo'><span class='span_text'>" . $this->Session->read('reset_error_msg') . "</span></div>";
                            $this->Session->delete("reset_error_msg");
                        }
                        if ($this->Session->check('success_msg')) {
                            echo "<div class='success_msg success_lo'><span class='span_text'>" . $this->Session->read('success_msg') . "</span></div>";
                            $this->Session->delete("success_msg");
                        }
                    ?>
        
        </h2> </div>
 </div>
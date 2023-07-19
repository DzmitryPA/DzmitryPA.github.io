<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview <?php if(isset($dashboardAct)) { echo 'active'; } ?>">
                <?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?>
            </li>
            <li class="treeview <?php if(isset($changeemail)  || isset($changepassword) || isset($changeusername) || isset($contactInfo)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-cogs"></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($changeemail)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Change Email', array('controller'=>'admins', 'action'=>'changeemail'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($changepassword)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Change Password', array('controller'=>'admins', 'action'=>'changepassword'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($changeusername)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Change Username', array('controller'=>'admins', 'action'=>'changeusername'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($contactInfo)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Contact Information', array('controller'=>'admins', 'action'=>'contactInfo'), array('escape'=>false));?></li>
                </ul>
            </li>
            
            <li class="treeview <?php if(isset($userList) || isset($userAdd)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-building"></i> <span>Manage Companies</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($userList)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Companies List', array('controller'=>'users', 'action'=>'index'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($userAdd)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Add Company', array('controller'=>'users', 'action'=>'add'), array('escape'=>false));?></li>
                </ul>
            </li>
            
            <?php /*<li class="treeview <?php if(isset($catListAct) || isset($catAdd)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-caret-square-o-down"></i> <span>Manage Categories</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($catListAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Categories List', array('controller'=>'categories', 'action'=>'index'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($catAdd)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Add Category', array('controller'=>'categories', 'action'=>'add'), array('escape'=>false));?></li>
                </ul>
            </li> */?>
            <li class="treeview <?php if(isset($industryListAct) || isset($indusAdd)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-industry"></i> <span>Manage Industries</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($industryListAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Industries List', array('controller'=>'industries', 'action'=>'index'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($indusAdd)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Add Industry', array('controller'=>'industries', 'action'=>'add'), array('escape'=>false));?></li>
                </ul>
            </li>
            
            
           <?php /* <li class="treeview <?php if(isset($stateListAct) || isset($stateAdd)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-location-arrow"></i> <span>Manage States</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($stateListAct)) { echo 'active'; } ?>"><?php echo $this->Html->link('States List', array('controller'=>'states', 'action'=>'index'), array('escape'=>false));?></li>
                    <li class="<?php if(isset($stateAdd)) { echo 'active'; } ?>"><?php echo $this->Html->link('Add State', array('controller'=>'states', 'action'=>'add'), array('escape'=>false));?></li>
                </ul>
            </li> */?>
            
            <li class="treeview <?php if(isset($page_list)) { echo 'active'; } ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-file-text-o"></i> <span>Manage Text Pages</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($page_list)) { echo 'active'; } ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Pages List', array('controller'=>'pages', 'action'=>'index'), array('escape'=>false));?></li>
                </ul>
            </li>
           
        </ul>
    </section>
</aside>


<div class="left_part">
    <div class="navigation" id="card">
        <ul class="mainmenu">
            <li><?php echo $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span>', array('controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'class' => (isset($dashboardAct)) ? "active" : "")); ?></li>
            
            <li><?php echo $this->Html->link('<i class="fa fa-book" aria-hidden="true"></i><span>Publications</span>', array('controller' => 'timelines', 'action' => 'index/'), array('escape' => false, 'class' => (isset($timelineAct)) ? "active" : "")); ?></li>
            
            <div class="relative_box <?php echo (isset($searchCompaniesAct)) ? "selected" : "" ?>">
                <li class="icon <?php echo (isset($searchCompaniesAct)) ? "current" : "" ?>"><?php echo $this->Html->link('<i class="fa fa-search" aria-hidden="true"></i> <span>Search</span>', 'javascript:void(0)', array('escape' => false, 'class' => "")); ?></li>
                <ul class="submenu">
                    <li><a href="javascript:void(0)">Products</a></li>
                    <li><a href="javascript:void(0)">Services</a></li>
                    <li class="<?php echo (isset($searchCompaniesAct)) ? "chosen" : "" ?>"><?php echo $this->Html->link('Companies', array('controller' => 'users', 'action' => 'searchCompanies'), array('escape' => false, 'class' => "")); ?></li>
                </ul>
            </div>
            
            <li><?php echo $this->Html->link('<i class="fa fa-desktop" aria-hidden="true"></i> <span>Profile</span>', array('controller' => 'users', 'action' => 'profile'), array('escape' => false, 'class' => (isset($profileAct)) ? "active" : "")); ?></li>
            <div class="relative_box">
                <li class="icon"><a><i class="fa fa-envelope" aria-hidden="true"></i> <span>Messages</span></a></li>
                <ul class="submenu">
                    <li><a href="javascript:void(0)">Inbox</a></li>
                    <li><a href="javascript:void(0)">View Message</a></li>
                    <li><a href="javascript:void(0)">New Message</a></li>
                </ul>
            </div>
            
            <li><a href="javascript:void(0)"><i class="fa fa-users" aria-hidden="true"></i> <span>Customers</span></a></li>
            
            <li><a href="javascript:void(0)"><i class="fa fa-truck" aria-hidden="true"></i> <span>Suppliers</span></a></li>
            
            <div class="relative_box <?php echo (isset($productListAct) || isset($serviceListAct) || isset($productAdd) || isset($serviceAdd)) ? "selected" : "" ?>">
                <li class="icon <?php echo (isset($productListAct) || isset($serviceListAct) || isset($productAdd) || isset($serviceAdd)) ? "current" : "" ?>"><?php echo $this->Html->link('<i class="fa fa-folder-open" aria-hidden="true"></i> <span>Products &AMP; Services</span>', 'javascript:void(0)', array('escape' => false, 'class' => "")); ?></li>
                <ul class="submenu">
                    <li class="<?php echo (isset($productListAct) || isset($productAdd)) ? "chosen" : "" ?>"><?php echo $this->Html->link('Manage Products', array('controller' => 'products', 'action' => 'index'), array('escape' => false, 'class' => "")); ?></li>
                    <li class="<?php echo (isset($serviceListAct) || isset($serviceAdd)) ? "chosen" : "" ?>"><?php echo $this->Html->link('Manage Services', array('controller' => 'services', 'action' => 'index'), array('escape' => false, 'class' => "")); ?></li>
                </ul>
            </div>
            <div class="relative_box">
                <li class="icon"><a><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Payments</span></a></li>
                <ul class="submenu">
                    <li><a href="javascript:void(0)">Incomes</a></li>
                    <li><a href="javascript:void(0)">Expenses</a></li>
                </ul>
            </div>
            <div class="relative_box">
                <li class="icon"><a><i class="fa fa-gavel" aria-hidden="true"></i> <span>Transactions</span></a></li>
                <ul class="submenu">
                    <li><a href="javascript:void(0)">Sales</a></li>
                    <li><a href="javascript:void(0)">Expenses</a></li>
                </ul>
            </div>
            <div class="relative_box">
                <li class="icon"><a><i class="fa fa-suitcase" aria-hidden="true"></i> <span>Leads</span></a></li>
                <ul class="submenu">
                    <li><a href="javascript:void(0)">Sales Leads</a></li>
                    <li><a href="javascript:void(0)">Buying Leads</a></li>
                </ul>
            </div>
            
            <div class="relative_box <?php echo (isset($followersAct) || isset($followingAct)) ? "selected" : "" ?>">
                <li class="icon <?php echo (isset($followersAct) || isset($followingAct)) ? "current" : "" ?>"><?php echo $this->Html->link('<i class="fa fa-arrows-alt" aria-hidden="true"></i> <span>Follow</span>', 'javascript:void(0)', array('escape' => false, 'class' => "")); ?></li>
                <ul class="submenu">
                    <li class="<?php echo (isset($followersAct)) ? "chosen" : "" ?>"><?php echo $this->Html->link('My Followers', array('controller' => 'follows', 'action' => 'myFollowers'), array('escape' => false, 'class' => "")); ?></li>
                    <li class="<?php echo (isset($followingAct)) ? "chosen" : "" ?>"><?php echo $this->Html->link('My Followings', array('controller' => 'follows', 'action' => 'myFollowings'), array('escape' => false, 'class' => "")); ?></li>
                </ul>
            </div>
            
            <li><?php echo $this->Html->link('<i class="fa fa-cogs" aria-hidden="true"></i> <span>Settings</span>', array('controller' => 'users', 'action' => 'setting'), array('escape' => false, 'class' => (isset($settingAct)) ? "active" : "")); ?></li>
        </ul>
    </div>
</div>
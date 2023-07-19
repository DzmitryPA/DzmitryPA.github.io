<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Stafir - Dashboard</title>

        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />


        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>-->
        <script type="text/javascript"> window.jQuery || document.write('<script src="js/jquery.min.js">' + "<" + "/script>");</script><script src="js/jquery.min.js"></script><script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
        <script src="js/retina.min.js" type="text/javascript" ></script>


        <script>
            $(document).ready(function() {
                $(".menu_icon").click(function() {
                    $(".navigation").toggleClass("left_icon");
                    $(".menu_icon").toggleClass("active");
                    $(".left_part").toggleClass("half");
                    $(".right_part").toggleClass("half");
                    $("body").toggleClass("web_rightside");
                });
            });
        </script>




        <script>
            $(document).ready(function() {

                // Make offer

                $("#makeoffer_popup").click(function() {
                    $("#makeoffer_popup_box").slideToggle("");
                });
                $("#makeoffer_popup_box_close").click(function() {
                    $("#makeoffer_popup_box").hide();
                });
                $("#makeoffer_popup").click(function() {
                    $("#makeoffer_popup").slideShow();
                });


                // Trade Comment

                $("#comment_trade").click(function() {
                    $("#comment_trade_box").toggle("");
                });

                // news Comment

                $("#comment_news").click(function() {
                    $("#comment_news_box").toggle("");
                });

                // lead Comment

                $("#comment_lead").click(function() {
                    $("#comment_lead_box").toggle("");
                });

            });
        </script>


    </head>

    <body>

        <div class="page">
            <header>

                <div class="header_left">
                    <div class="menu_icon"></div>
                    <div class="logo"><a href="index.html"><img src="img/logo.png" alt="img"/></a></div>
                </div>

                <div class="header_right">
                    <div class="notification_section_top">
                        <ul>
                            <li><div class="icn_noti"><i class="nav-icon fa fa-bullhorn"></i><span class="bg_colrred">5</span></div></li>
                            <li><div class="icn_noti"><i class="nav-icon fa fa-envelope"></i><span class="bg_colrred green">10</span></div></li>
                            <li><div class="icn_noti"><i class="nav-icon fa fa-gavel"></i><span class="bg_colrred green">10</span></div></li>
                            <li><div class="icn_noti"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span class="bg_colrred green">10</span></div></li>
                            <li><div class="icn_noti"><i class="nav-icon fa fa-power-off"></i></div></li>
                        </ul>
                    </div>
                </div>

            </header>

            <div class="left_part">
                <div class="navigation" id="card">
                    <ul class="mainmenu">
                        <li><a href="dashboard.html" class="active"><i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span></a></li>
                        <li><a href="publications.html"><i class="fa fa-book" aria-hidden="true"></i> <span>Publications</span></a></li>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-search" aria-hidden="true"></i> <span>Search</span></a></li>
                            <ul class="submenu">
                                <li><a href="search_product.html">Products</a></li>
                                <li><a href="search_service.html">Services</a></li>
                                <li><a href="search_industrie.html">Companies</a></li>
                            </ul>
                        </div>
                        <li><a href="index.html"><i class="fa fa-desktop" aria-hidden="true"></i> <span>Profile</span></a></li>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-envelope" aria-hidden="true"></i> <span>Messages</span></a></li>
                            <ul class="submenu">
                                <li><a href="message.html">Inbox</a></li>
                                <li><a href="view_message.html">View Message</a></li>
                                <li><a href="new_message.html">New Message</a></li>
                            </ul>
                        </div>
                        <li><a href="customers.html"><i class="fa fa-users" aria-hidden="true"></i> <span>Customers</span></a></li>
                        <li><a href="suppliers.html"><i class="fa fa-truck" aria-hidden="true"></i> <span>Suppliers</span></a></li>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-folder-open" aria-hidden="true"></i> <span>Products &AMP; Services</span></a></li>
                            <ul class="submenu">
                                <li><a href="product_page.html">Manage Products</a></li>
                                <li><a href="service_page.html">Manage Services</a></li>
                            </ul>
                        </div>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Payments</span></a></li>
                            <ul class="submenu">
                                <li><a href="payment_income.html">Incomes</a></li>
                                <li><a href="payment_expense.html">Expenses</a></li>
                            </ul>
                        </div>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-gavel" aria-hidden="true"></i> <span>Transactions</span></a></li>
                            <ul class="submenu">
                                <li><a href="transaction_sales.html">Sales</a></li>
                                <li><a href="transaction_expenses.html">Expenses</a></li>
                            </ul>
                        </div>
                        <div class="relative_box">
                            <li class="icon"><a><i class="fa fa-suitcase" aria-hidden="true"></i> <span>Leads</span></a></li>
                            <ul class="submenu">
                                <li><a href="leads_sales_leads.html">Sales Leads</a></li>
                                <li><a href="leads_buying_leads.html">Buying Leads</a></li>
                            </ul>
                        </div>
                        <li><a href="setting.html"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Settings</span></a></li>


                    </ul>
                </div>


            </div>



            <div class="right_part">

                <div class="aside_contaner_full_ne aside_contaner_full_ne_dks">
                    <div class="pad_of_titles pad_of_titlesdashboard">
                        <h2><i class="fa fa-home" aria-hidden="true"></i> &nbsp;Dashboard</h2>
                        <div class="pad_of_titles_rght">
                            <div class="pad_of_titles_rght_left"><span>Apple INC</span><p>Cupertino</p></div>
                            <div class="pad_of_titles_rght_right"><img src="img/ing_cvosm.png" alt="img"/></div>
                        </div>
                        <div class="clear"></div>

                        <div class="status_full_row">
                            <div class="status_full_col_left">
                                <div class="status_full_col_left_left"><div class="progress-bar-cusomes position progress_box_rad" id="progress-bar_paid" data-percent="85" data-duration="1000" data-color="#ccc"></div></div>
                                <div class="status_full_col_left_right">
                                    <div class="title_of_rga">Status of your Profile</div>
                                    <div class="clear"></div>

                                    <div class="profile_status_data">
                                        <ul>
                                            <li class="st_right">Add logo of your company</li>
                                            <li class="st_right">Add background picture</li>
                                            <li class="st_right">Add pictures to profile slider</li>
                                            <li class="st_right">Create About Us page</li>
                                            <li class="st_right">Add products or Services</li>
                                        </ul>
                                        <ul>
                                            <li class="st_right">Invite Supplier/s</li>
                                            <li class="st_right">Invite Customer/s</li>
                                            <li class="st_none">Post a Trading Offer</li>
                                            <li class="st_none">Post a News</li>
                                            <li class="st_none">Post a Buying Lead</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="status_full_col_right">
                                <div class="title_of_rga">This Month Activity</div>
                                <div class="section_of_bar_halff_infg">
                                    <div class="section_of_bar_halff">
                                        <div class="section_of_bar">                        
                                            <div class="clear_bar_sec_progress"><span class="sparkline-transactions">167,137,107,77,97,127,157</span></div>
                                        </div>
                                        <div class="section_of_bar">
                                            <div class="section_of_bar_title">Transactions</div>
                                            <div class="clear_bar_sec"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> 3,593</div>
                                        </div>
                                        <div class="data_censjd_thiss">500 Less than previous month</div>
                                    </div>
                                    <div class="section_of_bar_halff seconsection_of_bar_halff">
                                        <div class="section_of_bar">                        
                                            <div class="clear_bar_sec_progress"><span class="sparkline-sales">167,137,107,77,97,127,157</span></div>
                                        </div>

                                        <div class="section_of_bar">
                                            <div class="section_of_bar_title">Sales</div>
                                            <div class="clear_bar_sec"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> $ 1,423</div>
                                        </div> 
                                        <div class="data_censjd_thiss">500 More than previous month</div>
                                    </div>
                                    <div class="section_of_bar_halff">
                                        <div class="seconsection_of_bar_halffin">
                                            <div class="section_of_bar">                        
                                                <div class="clear_bar_sec_progress"><span class="sparkline-sales">167,137,107,77,97,127,157</span></div>
                                            </div>

                                            <div class="section_of_bar">
                                                <div class="section_of_bar_title">Expenses</div>
                                                <div class="clear_bar_sec"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> $ 1,566</div>
                                            </div> 
                                            <div class="data_censjd_thiss">500 Less than previous month</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>


                    <div class="cols_two_hal cols_two_hal_fulls">
                        <div class="bose_dash_full">

                            <div class="bose_dash_full_content">

                                <img src="img/dshboard_graph.png" alt="img"/>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="dashboa_full_box">


                        <div class="pading_sometis_tjo_prod">
                            <div class="">
                                <div class="cols_two_hal">
                                    <div class="bose_dash_full">
                                        <div class="bose_dash_full_header">Followers</div>
                                        <div class="bose_dash_full_content">
                                            <div class="bose_dash_full_contentsmale_prodview sdjfsjdhfjk sdjfsjdhfjk_smos">
                                                <div class="relative_box_esjad">
                                                    <div id="chartdiv" class="my_sales_chart" style="width:100%; height:360px;"></div>
                                                </div>
                                            </div>

                                            <div class="clear"></div>

                                            <div class="bose_dash_full_content bose_dash_full_content_msyskf">
                                                <div class="bose_dash_full_contentsmale_fill" id="content-1">
                                                    <div class="bose_dash_full_contentsmale_fill_tab">
                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>



                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>


                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">company_name@</span></div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                                <div class="cols_two_hal cols_two_hal_right cols_two_hal_right_sjd">
                                    <div class="bose_dash_full">
                                        <div class="bose_dash_full_header">Who Watch My Profile</div>
                                        <div class="bose_dash_full_content">
                                            <div class="bose_dash_full_contentsmale_prodview sdjfsjdhfjk sdjfsjdhfjk_smos">
                                                <div class="pie_chart_dfor">
                                                    <div class="pie_chart_dfor_left">
                                                        <canvas id="pie-chart-area" width="255" height="255"></canvas>
                                                    </div>
                                                    <div id="legend" class="pie_chart_menus"></div>
                                                </div>
                                            </div>

                                            <div class="clear"></div>

                                            <div class="bose_dash_full_content bose_dash_full_content_msyskf">
                                                <div class="bose_dash_full_contentsmale_fill" id="content-2">
                                                    <div class="bose_dash_full_contentsmale_fill_tab">
                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Electronics</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Automotive Services </span></div>
                                                        </div>



                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Electronics</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Automotive Services </span></div>
                                                        </div>


                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/imgls.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Apple INC</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Electronics</span></div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed">
                                                                    <img src="img/dell_logog.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_pahs">Dell</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">25<sub>th</sub> July, 2016</span></div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell"><span class="title_of_uid">Automotive Services </span></div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>



                        <div class="clear"></div>


                        <div class="pading_sometis_tjo_prod marf_sdf_hdfjgsjdfgj">
                            <div class="">
                                <div class="cols_two_hal cols_two_hal_pyufjs full_part_of_colse">




                                    <div class="bose_dash_full full_part_of_colse_riugt">
                                        <div class="bose_dash_full_header">Industries Interested About Your Products & Services</div>
                                        <div class="bose_dash_full_content">
                                            <div class="col_fos5_ths">
                                                <div class="bose_dash_full_contentsmale_fill bose_dash_full_content_msyskf bose_dash_full_content_msyskfdfsd" id="content-3">
                                                    <div class="bose_dash_full_contentsmale_fill_tab">
                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Consumer Electronics & Appliances</span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Telecommunications & Wireless </span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>



                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Apple Iphone 6s (64GB)</span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Machinery & Equipment</span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>


                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Nonclassifiable establishments </span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>

                                                        <div class="bose_dash_full_contentsmale_fill_row">
                                                            <div class="bose_dash_full_contentsmale_fill_cell img_cell_aya">
                                                                <div class="bose_dash_full_contentsmale_fill_cellsed_ig">
                                                                    <img src="img/ikskj.png" alt="img"/>
                                                                </div>
                                                            </div>
                                                            <div class="bose_dash_full_contentsmale_fill_cell">
                                                                <span class="title_of_pahs_tile">Medical Equipment & Device </span>
                                                                <span class="title_of_pahs_tile_susn">(18 views)</span>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col_fos5_ths">


                                                <div class="bose_dash_full_contentsmale_prodview sdjfsjdhfjk">
                                                    <div class="pie_chart_dfor pie_chart_dfor_smae">
                                                        <div class="pie_chart_dfor_left pie_chart_dfor_left_ats">
                                                            <canvas id="pie-chart-area_ne" width="300" height="300"></canvas>
                                                        </div>
                                                        <div id="legend_new" class="pie_chart_menus"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>




                            </div>


                        </div>
                    </div>



                    <div class="clear"></div>


                </div>


            </div>

        </div>
        </div>             

        <script src="js/pixel-admin.min.js"></script>

        <script type="text/javascript">
            //begin js
            $('.sparkline-transactions').sparkline('html', {
                type: 'bar',
                height: '37',
                barWidth: 7,
                barSpacing: 5,
                zeroAxis: false,
                tooltipPrefix: '$',
                barColor: '#148ed1',
                tooltipFormat: $.spformat('${{value}}', 'sparkline-tooltip')
            });
            $('.sparkline-sales').sparkline('html', {
                type: 'bar',
                height: '37',
                barWidth: 7,
                barSpacing: 5,
                zeroAxis: false,
                barColor: '#148ed1',
                tooltipFormat: $.spformat('${{value}}', 'sparkline-tooltip')
            });




            $('.rank').hover(function() {

                var $start = (parseInt($(this).attr('id').substr(4, 1)));



                $('.rank').addClass('rank-notactive');

                for (i = 1; i < $start + 1; i++) {

                    $('#main' + i).addClass('rank-active').removeClass('rank-notactive');

                    console.log($('#main' + i));

                }

            }, function() {

                $('.rank').removeClass('rank-active');

                $('.rank').removeClass('rank-notactive');

            });



            $('.rank').click(function() {

                var $start = (parseInt($(this).attr('id').substr(4, 1)));

                $('#inputRate').val($start);

                $('#submit_rate').submit();

            });



            $('#profile-slider').carousel();



            var bgperc = ($('#main-navbar').outerHeight() + $('#parallax').outerHeight()) / 100;

            $(window).scroll(function() {

                if (($('#main-navbar').outerHeight() + $('#parallax').outerHeight()) > $(document).scrollTop()) {

                    var bgposy = ($(document).scrollTop() / bgperc).toFixed(2);

                    $('#parallax').css('background-position', '50% ' + bgposy + '%');

                }

            });



            $('.followed').hover(
                    function() {

                        var $this = $(this); // caching $(this)

                        $this.data('initialText', $this.text());

                        $this.text("Unfollow");

                    },
                    function() {

                        var $this = $(this); // caching $(this)

                        $this.text($this.data('initialText'));

                    }

            );


            //$( '.cbp-fwslider' ).cbpFWSlider();




            //window.PixelAdmin.start(init);


            //end
        </script>


        <!-- Make Offer -->

        <div class="popup_full_sectiuons" id="makeoffer_popup_box">
            <div class="popup_insude_box">
                <div class="popup_close_btn" id="makeoffer_popup_box_close"></div>
                <h3 class="title_of_popup">Make Offer</h3>
                <div class="popup_insude_box_ins">
                    <div class="popup_insude_box_ins_nofull">
                        <div class="popup_fomr_row">
                            <label class="popup_title">Write Your Offer</label>
                            <div class="input_sor_boc">
                                <input type="text" name="write your offer"  class="popup_formtce"/>
                            </div>
                        </div>

                        <div class="popup_fomr_row">
                            <label class="popup_title">Price</label>
                            <div class="input_sor_boc">
                                <input type="text" name="Price"  class="popup_formtce"/>
                            </div>
                        </div>


                        <div class="popup_fomr_row">
                            <label class="popup_title">Quantity</label>
                            <div class="input_sor_boc">
                                <input type="text" name="Price"  class="popup_formtce"/>
                            </div>
                        </div>


                        <div class="popup_fomr_row">
                            <input type="button" name="skip" value="Submit" class="btn_add_sjskd"/>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <script src="js/chart/amcharts.js" type="text/javascript"></script>
        <script src="js/chart/serial.js" type="text/javascript"></script>
        <script src="js/chart/amstock.js" type="text/javascript"></script>


        <script>
            AmCharts.ready(function() {
                generateChartData();
                createStockChart();
            });

            var chartData = [];
            var arrayname = [];
            arrayname = [20, 50, 20, 75, 50, 15, 10, 14, 25, 10, 20, 10, 50, 20, 12, 50, 15, 10, 14, 25, 30, 10, 50, 20, 10, 50, 15, 10, 14, 10];
            function generateChartData() {
                var firstDate = new Date(2016, 06, 1);
                firstDate.setDate(firstDate.getDate() - 30);
                firstDate.setHours(0, 0, 0, 0);

                for (var i = 0; i < 30; i++) {
                    var newDate = new Date(firstDate);
                    newDate.setDate(newDate.getDate() + i);

                    //var value = Math.round(Math.random() * (30 + i)) + 10 + i;
                    var value = arrayname[i];

                    chartData.push({
                        date: newDate,
                        value: value
                    });
                }
            }


            function createStockChart() {
                var chart = new AmCharts.AmStockChart();


                // DATASETS //////////////////////////////////////////
                var dataSet = new AmCharts.DataSet();
                dataSet.color = "#b0de09";
                dataSet.fieldMappings = [{
                        fromField: "value",
                        toField: "value"
                    }];
                dataSet.dataProvider = chartData;
                dataSet.categoryField = "date";

                chart.dataSets = [dataSet];

                // PANELS ///////////////////////////////////////////
                var stockPanel = new AmCharts.StockPanel();
                stockPanel.showCategoryAxis = true;
                stockPanel.title = " ";
                stockPanel.eraseAll = false;
                stockPanel.addLabel(0, 20, " ", "center", 16);

                var graph = new AmCharts.StockGraph();
                graph.valueField = "value";
                graph.bullet = "round";
                graph.bulletColor = "#FFFFFF";
                graph.bulletBorderColor = "#f46554";
                graph.bulletBorderAlpha = 1;
                graph.bulletBorderThickness = 2;
                graph.bulletSize = 8;
                graph.lineThickness = 2;
                graph.lineColor = "#f46554";
                graph.useDataSetColors = false;
                stockPanel.addStockGraph(graph);

                var stockLegend = new AmCharts.StockLegend();
                stockLegend.valueTextRegular = " ";
                stockLegend.markerType = "none";
                stockPanel.stockLegend = stockLegend;
                stockPanel.drawingIconsEnabled = true;

                chart.panels = [stockPanel];


                // OTHER SETTINGS ////////////////////////////////////
                var scrollbarSettings = new AmCharts.ChartScrollbarSettings();
                scrollbarSettings.graph = graph;
                scrollbarSettings.updateOnReleaseOnly = false;
                chart.chartScrollbarSettings = scrollbarSettings;

                var cursorSettings = new AmCharts.ChartCursorSettings();
                cursorSettings.valueBalloonsEnabled = true;
                chart.chartCursorSettings = cursorSettings;

                var panelsSettings = new AmCharts.PanelsSettings();
                panelsSettings.creditsPosition = "bottom-right";
                panelsSettings.marginRight = 16;
                panelsSettings.marginLeft = 30;
                chart.panelsSettings = panelsSettings;


                // PERIOD SELECTOR ///////////////////////////////////
                var periodSelector = new AmCharts.PeriodSelector();
                periodSelector.position = "bottom";
                periodSelector.periods = [{
                        period: "DD",
                        count: 10,
                        label: "10 days"
                    }, {
                        period: "MM",
                        count: 1,
                        label: "1 month"
                    }];
                chart.periodSelector = periodSelector;

                chart.write('chartdiv');

            }

        </script>



        <script>
            $(document).ready(function() {


                AmCharts.ready(function() {
                    generateChartDatanew();
                    createStockChartnew();
                });
            });
            var chartDatanew = [];
            var arraynamenew = [];
            arraynamenew = [10, 15, 20, 75, 12, 15, 10, 14, 25, 80, 20, 10, 50, 20, 12, 50, 15, 10, 14, 25, 30, 10, 50, 20, 80, 50, 15, 10, 14, 25];
            function generateChartDatanew() {
                var firstDate = new Date(2016, 06, 1);
                firstDate.setDate(firstDate.getDate() - 30);
                firstDate.setHours(0, 0, 0, 0);

                for (var i = 0; i < 30; i++) {
                    var newDate = new Date(firstDate);
                    newDate.setDate(newDate.getDate() + i);

                    //var value = Math.round(Math.random() * (30 + i)) + 10 + i;
                    var value = arraynamenew[i];

                    chartDatanew.push({
                        date: newDate,
                        value: value
                    });
                }
            }


            function createStockChartnew() {
                var chartnew = new AmCharts.AmStockChart();


                // DATASETS //////////////////////////////////////////
                var dataSet = new AmCharts.DataSet();
                dataSet.color = "#b0de09";
                dataSet.fieldMappings = [{
                        fromField: "value",
                        toField: "value"
                    }];
                dataSet.dataProvider = chartDatanew;
                dataSet.categoryField = "date";

                chartnew.dataSets = [dataSet];

                // PANELS ///////////////////////////////////////////
                var stockPanel = new AmCharts.StockPanel();
                stockPanel.showCategoryAxis = true;
                stockPanel.title = " ";
                stockPanel.eraseAll = false;
                stockPanel.addLabel(0, 20, " ", "center", 16);

                var graph = new AmCharts.StockGraph();
                graph.valueField = "value";
                graph.bullet = "round";
                graph.bulletColor = "#FFFFFF";
                graph.bulletBorderColor = "#f46554";
                graph.bulletBorderAlpha = 1;
                graph.bulletBorderThickness = 2;
                graph.bulletSize = 8;
                graph.lineThickness = 2;
                graph.lineColor = "#f46554";
                graph.useDataSetColors = false;
                stockPanel.addStockGraph(graph);

                var stockLegend = new AmCharts.StockLegend();
                stockLegend.valueTextRegular = " ";
                stockLegend.markerType = "none";
                stockPanel.stockLegend = stockLegend;
                stockPanel.drawingIconsEnabled = true;

                chartnew.panels = [stockPanel];


                // OTHER SETTINGS ////////////////////////////////////
                var scrollbarSettings = new AmCharts.ChartScrollbarSettings();
                scrollbarSettings.graph = graph;
                scrollbarSettings.updateOnReleaseOnly = false;
                chartnew.chartScrollbarSettings = scrollbarSettings;

                var cursorSettings = new AmCharts.ChartCursorSettings();
                cursorSettings.valueBalloonsEnabled = true;
                chartnew.chartCursorSettings = cursorSettings;

                var panelsSettings = new AmCharts.PanelsSettings();
                panelsSettings.creditsPosition = "bottom-right";
                panelsSettings.marginRight = 16;
                panelsSettings.marginLeft = 30;
                chartnew.panelsSettings = panelsSettings;


                // PERIOD SELECTOR ///////////////////////////////////
                var periodSelector = new AmCharts.PeriodSelector();
                periodSelector.position = "bottom";
                periodSelector.periods = [{
                        period: "DD",
                        count: 10,
                        label: "10 days"
                    }, {
                        period: "MM",
                        count: 1,
                        label: "1 month"
                    }];
                chartnew.periodSelector = periodSelector;

                chartnew.write('chartdivtransition');

            }

        </script>















<!--    <script type="text/javascript" src="js/jscharts.js"></script>
<script type="text/javascript">
    var myData = new Array([0, 0], [5, 5], [10, 30], [15, 21], [20, 25], [25, 35], [30, 20]);
    var myChart = new JSChart('graph', 'line');
    myChart.setDataArray(myData);
    myChart.setTitle(' ');
    myChart.setTitleColor('#8E8E8E');
    myChart.setTitleFontSize(18);
    myChart.setAxisNameX('');
    myChart.setAxisNameY('');
    myChart.setAxisColor('#d5d5d5');
    myChart.setAxisValuesColor('#000000');
    myChart.setAxisValuesFontSize(14);
    myChart.setAxisPaddingLeft(50);
    myChart.setAxisPaddingRight(10);
    myChart.setAxisPaddingTop(10);
    myChart.setAxisPaddingBottom(40);
    myChart.setAxisValuesDecimals(0);
    myChart.setAxisValuesNumberX(7);
    
    myChart.setShowXValues(true);        
    
    myChart.setGridColor('#999');
    myChart.setLineColor('#90d44c');
    myChart.setLineWidth(3);
    myChart.setFlagColor('#90d44c');
    myChart.setFlagRadius(5);
    
    myChart.setTooltip([0, '0']);
    myChart.setTooltip([5, '5']);
    myChart.setTooltip([10, '10']);
    myChart.setTooltip([15, '15']);
    myChart.setTooltip([20, '20']);
    myChart.setTooltip([25, '25']);
    myChart.setTooltip([30, '30']);
    
    myChart.setLabelX([0, '']);
    myChart.setLabelX([5, '']);
    myChart.setLabelX([10, '']);
    myChart.setLabelX([15, '']);
    myChart.setLabelX([20, '']);
    myChart.setLabelX([25, '']);
    myChart.setLabelX([30, '']);
    
    myChart.setSize(590, 321);
    myChart.setBackgroundImage('chart_bg.jpg');
    myChart.draw();
</script>



<script type="text/javascript">
    var myData = new Array([1, 26], [5, 20], [10, 30], [15, 5], [20, 25], [25, 10], [30, 20]);
    var myChart = new JSChart('graph_right', 'line');
    myChart.setDataArray(myData);
    myChart.setTitle(' ');
    myChart.setTitleColor('#8E8E8E');
    myChart.setTitleFontSize(18);
    myChart.setAxisNameX('');
    myChart.setAxisNameY('');
    myChart.setAxisColor('#d5d5d5');
    myChart.setAxisValuesColor('#000000');
    myChart.setAxisValuesFontSize(14);
    myChart.setAxisPaddingLeft(50);
    myChart.setAxisPaddingRight(10);
    myChart.setAxisPaddingTop(10);
    myChart.setAxisPaddingBottom(40);
    myChart.setAxisValuesDecimals(0);
    myChart.setAxisValuesNumberX(7);
    
    myChart.setShowXValues(true);        
    
    myChart.setGridColor('#999');
    myChart.setLineColor('#f46554');
    myChart.setLineWidth(3);
    myChart.setFlagColor('#f46554');
    myChart.setFlagRadius(5);
    
    myChart.setTooltip([1, '1']);
    myChart.setTooltip([5, '5']);
    myChart.setTooltip([10, '10']);
    myChart.setTooltip([15, '15']);
    myChart.setTooltip([20, '20']);
    myChart.setTooltip([25, '25']);
    myChart.setTooltip([30, '30']);
    
    myChart.setLabelX([1, '']);
    myChart.setLabelX([5, '']);
    myChart.setLabelX([10, '']);
    myChart.setLabelX([15, '']);
    myChart.setLabelX([20, '']);
    myChart.setLabelX([25, '']);
    myChart.setLabelX([30, '']);
    
    myChart.setSize(590, 321);
    myChart.setBackgroundImage('chart_bg.jpg');
    myChart.draw();
</script>-->


<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      ['Agriculture',     35],
      ['Apparel',      15],
      ['Beverages',  15],
      ['Electrical', 20],
      ['Textiles',    15]
    ]);

   
    
    var options = {
    
    title: ' ',


   
  
   legend: {textStyle: {color: 'black', fontSize: 15}}
   

  };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
  
</script>-->





        <script src="js/chart/chart-min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                var pieData = [{
                        value: 35,
                        color: "#90d44c",
                        highlight: "#7fbd41",
                        label: "Agriculture"
                    }, {
                        value: 15,
                        color: "#5fb4f1",
                        highlight: "#51a3dd",
                        label: "Apparel"
                    }, {
                        value: 15,
                        color: "#f46554",
                        highlight: "#dd594a",
                        label: "Beverages"
                    }, {
                        value: 20,
                        color: "#eef455",
                        highlight: "#d8de4a",
                        label: "Electrical"
                    }, {
                        value: 15,
                        color: "#c49ef4",
                        highlight: "#ac88db",
                        label: "Textiles"
                    }];


                var pie_ctx = document.getElementById("pie-chart-area").getContext("2d");
                window.myPie = new Chart(pie_ctx).Pie(pieData, {
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                });

                var legend = myPie.generateLegend();
                $("#legend").html(legend);
            });
        </script>




        <script>
            $(document).ready(function() {
                var pieData = [{
                        value: 35,
                        color: "#90d44c",
                        highlight: "#7fbd41",
                        label: "Agriculture"
                    }, {
                        value: 15,
                        color: "#5fb4f1",
                        highlight: "#51a3dd",
                        label: "Apparel"
                    }, {
                        value: 15,
                        color: "#f46554",
                        highlight: "#dd594a",
                        label: "Beverages"
                    }, {
                        value: 20,
                        color: "#eef455",
                        highlight: "#d8de4a",
                        label: "Electrical"
                    }, {
                        value: 15,
                        color: "#c49ef4",
                        highlight: "#ac88db",
                        label: "Textiles"
                    }];


                var pie_ctx = document.getElementById("pie-chart-area_ne").getContext("2d");
                window.myPie = new Chart(pie_ctx).Pie(pieData, {
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                });

                var legend = myPie.generateLegend();
                $("#legend_new").html(legend);
            });
        </script>





        <script>
            $(document).ready(function() {
                var pieData = [{
                        value: 10,
                        color: "#90d44c",
                        highlight: "#7fbd41",
                        label: "Agriculture"
                    }, {
                        value: 10,
                        color: "#5fb4f1",
                        highlight: "#51a3dd",
                        label: "Apparel"
                    }, {
                        value: 10,
                        color: "#f46554",
                        highlight: "#dd594a",
                        label: "Beverages"
                    }, {
                        value: 10,
                        color: "#eef455",
                        highlight: "#d8de4a",
                        label: "Electrical"
                    }, {
                        value: 10,
                        color: "#c49ef4",
                        highlight: "#ac88db",
                        label: "Textiles"
                    }];


                var pie_ctx = document.getElementById("pie-chart-area_pr").getContext("2d");
                window.myPie = new Chart(pie_ctx).Pie(pieData, {
                    //legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                });
            });
        </script>



        <link rel="stylesheet" href="js/scroll/jquery.mCustomScrollbar.css">
            <script src="js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>

            <script>
            (function($) {
                $(window).on("load", function() {

                    $("#content-1").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "rounded"
                    });

                });
                //
                $(window).on("load", function() {

                    $("#content-2").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "rounded"
                    });

                });

                //
                $(window).on("load", function() {

                    $("#content-3").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "rounded"
                    });

                });

            })(jQuery);
            </script>

            <link href="css/jQuery-plugin-progressbar.css" type="text/css" rel="stylesheet"/>
            <script src="js/jQuery-plugin-progressbar.js" type="text/javascript"></script>

            <script>
            $("#progress-bar_paid").loading();
            </script>


    </body>
</html>




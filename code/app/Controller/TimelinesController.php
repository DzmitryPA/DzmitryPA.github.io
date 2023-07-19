<?php

class TimelinesController extends AppController {

    public $name = 'Timelines';
    public $uses = array('Admin', 'User', 'State', 'City', 'Industry', 'Timeline', 'Follow', 'Comment', 'Offer');
    public $helpers = array('Html', 'Form', 'Paginator', 'Javascript', 'Ajax', 'Js', 'Text', 'Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Product.name' => 'asc'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha');
    public $layout = 'admin';

    function beforeFilter() {
        $loggedAdminId = $this->Session->read("adminid");
        if (isset($this->params['admin']) && $this->params['admin'] && !$loggedAdminId) {
            $returnUrlAdmin = $this->params->url;
            $this->Session->write("returnUrlAdmin", $returnUrlAdmin);
            $this->redirect(array('controller' => 'admins', 'action' => 'login', ''));
        }
    }

    public function index() {
        $this->layout = "client";
        $this->set('timelineAct', 1);
        $this->set('title_for_layout', TITLE_FOR_PAGES . 'Manage Publications');

        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        $userInfo = $this->User->findById($userId);
        $this->set('userInfo', $userInfo);

        $followingCompaniesIds = array();
        $conditionFollow = array('Follow.follower_id' => $userId);
        $followingCompaniesIds = $this->Follow->find('list', array('conditions' => $conditionFollow, 'fields' => array('Follow.following_id')));

        if ($userInfo['User']['show_own_post'] == 0) {
            array_push($followingCompaniesIds, $userId);
        }
        $followingFinalIds = array_values($followingCompaniesIds);
        $implodedArray = implode(',', $followingFinalIds);

        // pr($implodedArray); exit;
        $condition = array();
        $separator = array();
        $urlSeparator = array();

        if ($userInfo['User']['show_own_post'] == 0) {
            $condition = array('OR' => array('OR' => array('Timeline.post_type' => 0, 'Timeline.user_id' => $this->Session->read('user_id'), 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])),
                array('OR' => array('Timeline.post_type' => 1,'Timeline.user_id' => $followingFinalIds)),
                array('OR' => array('Timeline.post_type' => 2, 'Timeline.user_id' => $this->Session->read('user_id'), 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
        } else {
//           $condition = " ((`Timeline`.`post_type` = '0' OR `Timeline`.`user_id` = '" . $userId . "' " 
//                                . "OR  `Timeline`.`industry_id` != '" . $userInfo['User']['industry_id'] . "' "
//                                . "OR  `Timeline`.`subindustry_id` != '" . $userInfo['User']['subindustry_id'] . "' "
//                                . "OR  `Timeline`.`state_id` != '" . $userInfo['User']['state_id'] . "' "
//                                . "OR  `Timeline`.`city_id` != '" . $userInfo['User']['city_id'] . "' ) "
//                        . "OR (`Timeline`.`post_type` = '0' OR `Timeline`.`user_id` = '" . $userId . "' " 
//                                . "OR  `Timeline`.`industry_id` != '" . $userInfo['User']['industry_id'] . "' "
//                                . "OR  `Timeline`.`subindustry_id` != '" . $userInfo['User']['subindustry_id'] . "' "
//                                . "OR  `Timeline`.`state_id` != '" . $userInfo['User']['state_id'] . "' "
//                                . "OR  `Timeline`.`city_id` != '" . $userInfo['User']['city_id'] . "' )"
//                        . " OR (`Timeline`.`post_type` = '0' OR `Timeline`.`user_id` = '" . $userId . "' " 
//                                . "OR  `Timeline`.`industry_id` != '" . $userInfo['User']['industry_id'] . "' "
//                                . "OR  `Timeline`.`subindustry_id` != '" . $userInfo['User']['subindustry_id'] . "' "
//                                . "OR  `Timeline`.`state_id` != '" . $userInfo['User']['state_id'] . "' "
//                                . "OR  `Timeline`.`city_id` != '" . $userInfo['User']['city_id'] . "' )) ";
            
            $condition[] = array('Timeline.user_id !=' => $this->Session->read('user_id'));
            $condition[] = array('OR' => array('OR' => array('Timeline.post_type' => 0, 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])),
                array('OR' => array('Timeline.post_type' => 1, 'Timeline.user_id' => $followingFinalIds)),
                array('OR' => array('Timeline.post_type' => 2, 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
            
        }

        $stateList = $this->State->getList();
        $this->set('stateList', $stateList);
        $cityList = array();
        $industryList = $this->Industry->getList();
        $this->set('industryList', $industryList);
        $subIndustryList = array();

//        $data = $this->Timeline->find('all');
//        pr($data); exit;

        if ($this->data) {
            //pr($this->data); exit;
            if (isset($this->data['tradeOffer']) && !empty($this->data['tradeOffer'])) {
                $this->request->data["Timeline"]["description"] = trim($this->data["Timeline"]["description"]);
                if (empty($this->data["Timeline"]["description"])) {
                    $msgString .="- Trade Offer Description is required field.<br>";
                }

                if ($this->data["Timeline"]["image"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data["Timeline"]["image"]['name']);
                    $extention = strtolower($getextention);
                    global $imageextentions;
                    if (!in_array($extention, $imageextentions)) {
                        $msgString .="- Not valid extention for Trade Offer Image.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for Trade Offer Image.<br>";
                    }
                }

                if (isset($msgString) && $msgString != '') {
                    $cityList = $this->City->getList($this->data['User']['state_id']);
                    $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
                    $this->Session->setFlash($msgString, 'error_msg');
                } else {
                    if ($this->data["Timeline"]["image"]["name"]) {
                        $this->request->data["Timeline"]["image"]['name'] = str_replace($specialCharacters, $toReplace, $this->data["Timeline"]["image"]['name']);
                        $imageArray = $this->data["Timeline"]["image"];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_TIMELINE_POST_PATH);
                        $this->request->data["Timeline"]["image"] = $returnedUploadImageArray[0];
                    } else {
                        $this->request->data["Timeline"]["image"] = '';
                    }

                    $this->request->data['Timeline']['slug'] = $this->stringToSlugUnique(date('Ymdhis') . $userId . mt_rand(100, 1000), 'Timeline');
                    $this->request->data['Timeline']['status'] = 1;
                    $this->request->data['Timeline']['user_id'] = $userId;
                    $this->request->data['Timeline']['post_type'] = 0;

                    if ($this->Timeline->save($this->data)) {
                        $productId = $this->Product->id;

                        $this->Session->setFlash('Trade Offer Post Added Successfully', 'success_msg');
                        $this->redirect(array('controller' => 'timelines', 'action' => 'index/'));
                    }
                }
            } elseif (isset($this->data['newsPost']) && !empty($this->data['newsPost'])) {
                $this->request->data["Timeline"]["description"] = trim($this->data["Timeline"]["description"]);
                if (empty($this->data["Timeline"]["description"])) {
                    $msgString .="- News Description is required field.<br>";
                }

                if ($this->data["Timeline"]["image"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data["Timeline"]["image"]['name']);
                    $extention = strtolower($getextention);
                    global $imageextentions;
                    if (!in_array($extention, $imageextentions)) {
                        $msgString .="- Not valid extention for Image.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for Image.<br>";
                    }
                }

                if (isset($msgString) && $msgString != '') {
                    $cityList = $this->City->getList($this->data['User']['state_id']);
                    $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
                    $this->Session->setFlash($msgString, 'error_msg');
                } else {
                    if ($this->data["Timeline"]["image"]["name"]) {
                        $this->request->data["Timeline"]["image"]['name'] = str_replace($specialCharacters, $toReplace, $this->data["Timeline"]["image"]['name']);
                        $imageArray = $this->data["Timeline"]["image"];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_TIMELINE_POST_PATH);
                        $this->request->data["Timeline"]["image"] = $returnedUploadImageArray[0];
                    } else {
                        $this->request->data["Timeline"]["image"] = '';
                    }

                    $this->request->data['Timeline']['slug'] = $this->stringToSlugUnique(date('Ymdhis') . $userId . mt_rand(100, 1000), 'Timeline');
                    $this->request->data['Timeline']['status'] = 1;
                    $this->request->data['Timeline']['user_id'] = $userId;
                    $this->request->data['Timeline']['post_type'] = 1;

                    if ($this->Timeline->save($this->data)) {
                        $productId = $this->Product->id;

                        $this->Session->setFlash('News Post Added Successfully', 'success_msg');
                        $this->redirect(array('controller' => 'timelines', 'action' => 'index/'));
                    }
                }
            } elseif (isset($this->data['buyingLeadPost']) && !empty($this->data['buyingLeadPost'])) {
                $this->request->data["Timeline"]["description"] = trim($this->data["Timeline"]["description"]);
                if (empty($this->data["Timeline"]["description"])) {
                    $msgString .="- Product/Service Description is required field.<br>";
                }
                $this->request->data["Timeline"]["product_name"] = trim($this->data["Timeline"]["product_name"]);
                if (empty($this->data["Timeline"]["product_name"])) {
                    $msgString .="- Product Name is required field.<br>";
                }
                if (empty($this->data["Timeline"]["quantity"])) {
                    $msgString .="- Quantity is required field.<br>";
                }
                if (empty($this->data["Timeline"]["asking_price"])) {
                    $msgString .="- Asking Price is required field.<br>";
                }

                if ($this->data["Timeline"]["image"]["name"]) {
                    $getextention = $this->PImage->getExtension($this->data["Timeline"]["image"]['name']);
                    $extention = strtolower($getextention);
                    global $imageextentions;
                    if (!in_array($extention, $imageextentions)) {
                        $msgString .="- Not valid extention for Image.<br>";
                    } elseif ($this->data['User']['certificates']['size'] > '2097152') {
                        $msgString .="- Max file size upload is 2MB for Image.<br>";
                    }
                }

                if (isset($msgString) && $msgString != '') {
                    $cityList = $this->City->getList($this->data['User']['state_id']);
                    $subIndustryList = $this->Industry->getSubIndustryList($this->data['User']['industry_id']);
                    $this->Session->setFlash($msgString, 'error_msg');
                } else {
                    if ($this->data["Timeline"]["image"]["name"]) {
                        $this->request->data["Timeline"]["image"]['name'] = str_replace($specialCharacters, $toReplace, $this->data["Timeline"]["image"]['name']);
                        $imageArray = $this->data["Timeline"]["image"];
                        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_TIMELINE_POST_PATH);
                        $this->request->data["Timeline"]["image"] = $returnedUploadImageArray[0];
                    } else {
                        $this->request->data["Timeline"]["image"] = '';
                    }

                    $this->request->data['Timeline']['slug'] = $this->stringToSlugUnique(date('Ymdhis') . $userId . mt_rand(100, 1000), 'Timeline');
                    $this->request->data['Timeline']['status'] = 1;
                    $this->request->data['Timeline']['user_id'] = $userId;
                    $this->request->data['Timeline']['post_type'] = 2;

                    if ($this->Timeline->save($this->data)) {
                        $productId = $this->Product->id;

                        $this->Session->setFlash('Buying Lead Post Added Successfully', 'success_msg');
                        $this->redirect(array('controller' => 'timelines', 'action' => 'index/'));
                    }
                }
            }
        }

        $this->set('cityList', $cityList);
        $this->set('subIndustryList', $subIndustryList);

        $this->paginate['Timeline'] = array(
            'conditions' => $condition,
            'order' => array('Timeline.id' => 'DESC'),
            'limit' => '20'
        );

//        pr($condition);
//        pr($this->paginate('Timeline', $condition)); exit;
        $this->set('timelines', $this->paginate('Timeline', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'timelines/';
            $this->render('index');
        }
    }

    public function updateFilter($type = null) {
        $this->layout = "";

        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        $userInfo = $this->User->findById($userId);

        $followingCompaniesIds = array();
        $conditionFollow = array('Follow.follower_id' => $userId);
        $followingCompaniesIds = $this->Follow->find('list', array('conditions' => $conditionFollow, 'fields' => array('Follow.following_id')));
        if ($userInfo['User']['show_own_post'] == 0) {
            array_push($followingCompaniesIds, $userId);
        }

        $followingFinalIds = array_values($followingCompaniesIds);

//       pr($followingFinalIds); exit;
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        if ($userInfo['User']['show_own_post'] == 0) {
            if ($type == 1) {
                $condition = array('Timeline.post_type' => 0, array('OR' => array('Timeline.user_id' => $this->Session->read('user_id'), 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
            } elseif ($type == 2) {
                $condition = array('Timeline.post_type' => 1, 'Timeline.user_id' => $followingFinalIds);
            } elseif ($type == 3) {
                $condition = array('Timeline.post_type' => 2, array('OR' => array('Timeline.user_id' => $this->Session->read('user_id'), 'Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
            }
        } else {
            if ($type == 1) {
                $condition = array('Timeline.post_type' => 0, 'Timeline.user_id !=' => $this->Session->read('user_id'), array('OR' => array('Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
            } elseif ($type == 2) {
                $condition = array('Timeline.post_type' => 1, 'Timeline.user_id' => $followingFinalIds);
            } elseif ($type == 3) {
                $condition = array('Timeline.post_type' => 2, 'Timeline.user_id !=' => $this->Session->read('user_id'), array('OR' => array('Timeline.industry_id' => $userInfo['User']['industry_id'], 'Timeline.subindustry_id' => $userInfo['User']['subindustry_id'], 'Timeline.state_id' => $userInfo['User']['state_id'], 'Timeline.city_id' => $userInfo['User']['city_id'])));
            }
        }


        $this->paginate['Timeline'] = array(
            'conditions' => $condition,
            'order' => array('Timeline.id' => 'DESC'),
            'limit' => '1'
        );

//pr($condition); exit;
//        pr($this->paginate('Timeline', $condition)); exit;
        $this->set('timelines', $this->paginate('Timeline', $condition));
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'timelines/';
            $this->render('otherposts');
        }
    }

    public function postComment() {
        $this->layout = "";
        //$this->autoRender = false;

        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        $userInfo = $this->User->findById($userId);

        if ($this->data) {
            $timelineId = $this->data['Comment']['timeline_id'];
            $this->request->data['Comment']['timeline_id'] = $timelineId;
            $this->request->data['Comment']['from_user_id'] = $userId;
            $this->request->data['Comment']['timeline_id'] = $timelineId;
            $this->request->data['Comment']['slug'] = $this->stringToSlugUnique(date('Ymdhis') . $timelineId . $userId . mt_rand(100, 1000), 'Comment', 'slug');
            $this->request->data['Comment']['status'] = 1;

            if ($this->Comment->save($this->data)) {
                $lastCommId = $this->Comment->id;
                $cond = array('Comment.id' => $lastCommId, 'Comment.status' => 1);
                $comment = $this->Comment->find('first', array('conditions' => $cond));
                $this->set('comment', $comment);

                if ($this->request->is('ajax')) {
                    $this->layout = '';
                    $this->viewPath = 'Elements' . DS . 'timelines/';
                    $this->render('post_comment');
                }
            }
        }
    }

    public function deleteComment($id, $slug) {
        $this->autoRender = false;
        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        if ($id != $userId || $slug == "") {
            return false;
        } else {
            $commentInfo = $this->Comment->field('id', array('Comment.slug' => $slug));
            if ($commentInfo) {
                $this->Comment->delete($commentInfo);
                return true;
            } else {
                return false;
            }
        }
        exit;
    }

    public function saveOfferData() {
        $this->layout = "";
        $this->autoRender = false;
        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        $userInfo = $this->User->findById($userId);

        if ($this->data) {
            $timelineId = $this->data['Offer']['timeline_id'];
            $this->request->data['Offer']['timeline_id'] = $timelineId;
            $this->request->data['Offer']['from_user_id'] = $userId;
            $this->request->data['Offer']['timeline_id'] = $timelineId;
            $this->request->data['Offer']['slug'] = $this->stringToSlugUnique(date('Ymdhis') . $timelineId . $userId . mt_rand(100, 1000), 'Offer', 'slug');
            $this->request->data['Offer']['status'] = 1;

            if ($this->Offer->save($this->data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function setownposts($type) {
        $this->autoRender = false;
        $this->userLoginCheck();
        $userId = $this->Session->read('user_id');
        if ($type == "" || $userId == "") {
            return false;
        } else {
            $this->User->updateAll(array('User.show_own_post' => $type), array("User.id" => $userId));
            return true;
        }
        exit;
    }

}

//End TimelinesController Class
?>

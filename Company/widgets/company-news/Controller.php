<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     John Boehr <john@socialengine.com>
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Widget_CompanyNewsController extends Engine_Content_Widget_Abstract
{
    public function indexAction() {
/*
        $sitenews_browse_news = Zend_Registry::isRegistered('sitenews_browse_news') ? Zend_Registry::get('sitenews_browse_news') : null;
        if(empty($sitenews_browse_news))
            return $this->setNoRender(); */

            $this->view->addHelperPath(APPLICATION_PATH . '/application/modules/Sitenews/View/Helper', 'Sitenews_View_Helper');
            $request = Zend_Controller_Front::getInstance()->getRequest();
            $params = $request->getParams();

            $this->view->defaultViewType = $params['defaultViewType'] = $this->_getParam('defaultViewType', 'gridView');
            if (!isset($params['viewFormat']))
                $this->view->viewFormat = $params['viewFormat'] = $params['defaultViewType'];
                else
                    $this->view->viewFormat = $params['viewFormat'];
                    if (isset($params['page']) && !empty($params['page']))
                        $page = $params['page'];
                        else
                            $page = $this->_getParam('page', 1);
                            //        $this->view->rss = $params['rss'] = $this->_getParam('rss');
                            $this->view->showPhotosInJustifiedView = $params['showPhotosInJustifiedView'] = $this->_getParam('showPhotosInJustifiedView', 0);
                            $this->view->maxRowHeight = $params['maxRowHeight'] = $this->_getParam('maxRowHeight', 0);
                            $this->view->rowHeight = $params['rowHeight'] = $this->_getParam('rowHeight', 205);
                            $this->view->margin = $params['margin'] = $this->_getParam('margin', 0);
                            $this->view->lastRow = $params['lastRow'] = $this->_getParam('lastRow', 'nojustify');
                            $this->view->newsWithRssTitleView = $params['newsWithRssTitleView'] = $this->_getParam('newsWithRssTitleView');
                            $this->view->descriptionInBlock = $params['descriptionInBlock'] = $this->_getParam('descriptionInBlock');
                            $this->view->viewType = $params['viewType'] = $this->_getParam('viewType', array('gridView', 'listView'));
                            //        $this->view->newsViewWidth = $params['newsViewWidth'] = $this->_getParam('newsViewWidth', 150);
                            //        $this->view->newsViewHeight = $params['newsViewHeight'] = $this->_getParam('newsViewHeight', 150);
                            $this->view->gridViewWidth = $params['gridViewWidth'] = $this->_getParam('gridViewWidth', 250);
                            $this->view->gridViewHeight = $params['gridViewHeight'] = $this->_getParam('gridViewHeight', 200);
                            $this->view->newsOption = $params['newsOption'] = $this->_getParam('newsOption');
                            $this->view->showContent = $params['show_content'] = $this->_getParam('show_content', 2);
                            $this->view->itemCountPerPage = $params['itemCountPerPage'] = $this->_getParam('itemCountPerPage', 12);
                            $this->view->is_ajax = $params['is_ajax'] = $this->_getParam('is_ajax', false);
                            $this->view->titleTruncationListView = $this->view->titleTruncationGridNNewsView = $params['titleTruncation'] = $this->_getParam('titleTruncation', 22);
                            //        $this->view->titleTruncationGridView = $params['titleTruncationGridNVideoView'] = $this->_getParam('titleTruncationGridNVideoView', 100);
                            $this->view->id = $params['id'] = $this->_getParam('identity');
                            $this->view->feedsCountPerPage = $params['feedsCountPerPage'] = $this->_getParam('feedsCountPerPage');
                            $this->view->newsRssCountPerPage = $params['newsRssCountPerPage'] = $this->_getParam('newsRssCountPerPage');
                            $this->view->descriptionTruncation = $params['descriptionTruncation'] = $this->_getParam('descriptionTruncation', 200);
                            $this->view->locationDetection = $this->view->detactLocation = $params['detactLocation'] = $this->_getParam('detactLocation', 0);
                            if ($this->view->detactLocation) {
                                $this->view->detactLocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('sitenews.news.location', 0);
                            }
                            if (empty($this->view->newsOption) || !is_array($this->view->newsOption)) {
                                $this->view->newsOption = $params['newsOption'] = array();
                            }

                            $this->view->listDescription = $this->_getParam('listDescription', 1);
                            $this->view->gridDescription = $this->_getParam('gridDescription', 0);

                            $this->view->listViewWithPhoto = $this->_getParam('listViewWithPhoto', 1);
                            //$this->view->titleInsideGrid = $this->_getParam('titleInsideGrid', 0);
                            $this->view->descriptionInsideGrid = $this->_getParam('descriptionInsideGrid', 0);
                            $this->view->defaultLocationDistance = 1000;
                            $this->view->latitude = 0;
                            $this->view->longitude = 0;
                            $this->view->noAdminPhoto = true;
                            if ($this->view->detactLocation) {
                                $this->view->defaultLocationDistance = $params['defaultLocationDistance'] = $this->_getParam('defaultLocationDistance', 1000);
                                $this->view->latitude = $params['latitude'] = $this->_getParam('latitude', 0);
                                $this->view->longitude = $params['longitude'] = $this->_getParam('longitude', 0);
                            }
                            if (!isset($params['category_id']))
                                $params['category_id'] = 0;
                                if (!isset($params['subcategory_id']))
                                    $params['subcategory_id'] = 0;
                                    if (!isset($params['subsubcategory_id']))
                                        $params['subsubcategory_id'] = 0;
                                        if (empty($params['category_id'])) {
                                            $this->view->category_id = $params['category_id'] = $this->_getParam('category_id', $this->_getParam('category'));
                                            $params['subcategory_id'] = $this->_getParam('subcategory_id', $this->_getParam('subcategory_id'));
                                            $params['subsubcategory_id'] = $this->_getParam('subsubcategory_id', $this->_getParam('subsubcategory_id'));
                                        }

                                        //GET CATEGORYID AND SUBCATEGORYID
                                        $this->view->categoryName = '';
                                        if ($this->view->category_id) {
                                            $this->view->categoryName = $params['categoryname'] = Engine_Api::_()->getItem('sitenews_category', $this->view->category_id)->category_name;
                                            if ($this->view->subcategory_id) {
                                                $this->view->subCategoryName = $params['subcategoryname'] = Engine_Api::_()->getItem('sitenews_category', $this->view->subcategory_id)->category_name;
                                            }

                                            if ($this->view->subsubcategory_id) {
                                                $this->view->subsubCategoryName = $params['subsubcategoryname'] = Engine_Api::_()->getItem('sitenews_category', $this->view->subsubcategory_id)->category_name;
                                            }
                                        }
                                        //FORM GENERATION
                                        $widgetSettings = array(
                                            'locationDetection' => $this->view->locationDetection,
                                            'showAllCategories' => 1
                                        );

                                        $form = new Sitenews_Form_Search_NewsSearch(array('widgetSettings' => $widgetSettings));
                                        if (!empty($params)) {
                                            $form->populate($params);
                                        }
                                        $this->view->formValues = $form->getValues();

                                        $params = array_merge($params, $form->getValues());

                                        $requestedAllParams = $this->_getAllParams();
                                        if (isset($requestedAllParams['hidden_news_category_id']) && !empty($requestedAllParams['hidden_news_category_id'])) {
                                            $this->view->category_id = $params['category_id'] = $this->_getParam('hidden_news_category_id');
                                            $this->view->subcategory_id = $params['subcategory_id'] = $this->_getParam('hidden_news_subcategory_id');
                                            $this->view->subsubcategory_id = $params['subsubcategory_id'] = $this->_getParam('hidden_news_subsubcategory_id');
                                        }


                                        $request = Zend_Controller_Front::getInstance()->getRequest();
                                        $params['newsType'] = $contentType = $request->getParam('newsType', null);
                                        if (empty($contentType)) {
                                            $params['newsType'] = $params['newsType'] = $this->_getParam('newsType', 'All');
                                        }
                                        $this->view->newsType = $params['newsType'];

                                        // FIND USERS' FRIENDS
                                        $viewer = Engine_Api::_()->user()->getViewer();
                                        if (!empty($params['view_view']) && $params['view_view'] == 1) {
                                            //GET AN ARRAY OF FRIEND IDS
                                            $friends = $viewer->membership()->getMembers();
                                            $ids = array();
                                            foreach ($friends as $friend) {
                                                $ids[] = $friend->user_id;
                                            }
                                            $params['users'] = $ids;
                                        }

                                        //CUSTOM FIELD WORK

                                        $params['orderby'] = $orderby = $this->_getParam('orderby', 'creation_date');
                                        $viewer_id = $this->view->viewerId = $viewer->getIdentity();
                                        if (!empty($viewer_id)) {
                                            $level_id = Engine_Api::_()->user()->getViewer()->level_id;
                                        } else {
                                            $level_id = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchRow(array('type = ?' => "public"))->level_id;
                                        }
                                        $this->view->can_create = $can_create = Engine_Api::_()->authorization()->getPermission($level_id, 'sitenews_news', 'create');
                                        $newsSize = array();
                                        $newsSize['thumb.normal'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('normal.news.width', 375);
                                        $newsSize['thumb.large'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('normallarge.news.width', 720);
                                        $newsSize['thumb.main'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('main.news.height', 1600);
                                        $newsSize['width'] = $this->view->newsViewWidth;
                                        $thumbnailType = Engine_Api::_()->getApi('core', 'sitenews')->findThumbnailType($newsSize, $this->view->newsViewWidth);
                                        $this->view->newsViewThumbnailType = $params['newsViewThumbnailType'] = $thumbnailType;
                                        $newsSize['width'] = $this->view->gridViewWidth;
                                        $thumbnailType = Engine_Api::_()->getApi('core', 'sitenews')->findThumbnailType($newsSize, $this->view->newsViewWidth);
                                        $this->view->gridViewThumbnailType = $params['gridViewThumbnailType'] = $thumbnailType;
                                        $params['type'] = 'browse';
                                        $element = $this->getElement();
                                        $widgetTitle = $this->view->heading = $element->getTitle();

                                        if (!empty($widgetTitle)) {
                                            $element->setTitle("");
                                        } else {
                                            $this->view->heading = "";
                                        }
                                        $this->view->params = $params;
                                        $this->view->widgetPath = 'widget/index/mod/sitenews/name/browse-news-sitenews';
                                        $this->view->message = 'Nobody has added a News yet.';
                                        if ((isset($params['search']) && !empty($params['search'])) || (isset($params['category_id']) && !empty($params['category_id'])) || (isset($params['subcategory_id']) && !empty($params['subcategory_id'])) || (isset($params['tag_id']) && !empty($params['tag_id'])) || (isset($params['location']) && !empty($params['location'])))
                                            $this->view->message = 'Nobody has added a News with this criteria.';
                                            $this->view->isViewMoreButton = false;
                                            $this->view->showViewMore = true;
                                            $this->view->published = "all";

                                            $this->view->categoryids = $params['categoryids'] = $categoryids = $this->_getParam('categoryids');
                                            $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('news', 'sitenews')->getNewsPaginator($params);



                                            $this->view->totalCount = $paginator->getTotalItemCount();
                                            $paginator->setItemCountPerPage($params['itemCountPerPage']);
                                            $paginator->setCurrentPageNumber($page);
    }
}

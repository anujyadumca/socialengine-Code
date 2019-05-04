<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitenews
 * @copyright  Copyright 2016-2017 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 2017-01-01 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>
<?php  
$this->params['identity'] = $this->identity;
if (!$this->id)
    $this->id = $this->identity;
?>
<?php
$baseUrl = $this->layout()->staticBaseUrl;
$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Seaocore/externals/styles/styles.css');
$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sitenews/externals/styles/style_sitenews.css');
?>
<?php if (empty($this->is_ajax)): ?>
<div class="layout_core_container_tabs">
    <div class="sitenews_browse_lists_view_options txt_right" id='newsViewFormat' style="display:<?php echo count($this->viewType) > 1 ? 'block' : 'none' ?>">
        <div class="fleft">
                <?php if (empty($this->heading)) : ?>
                    <?php echo $this->translate(array('%s news found.', '%s news found.', $this->totalCount), $this->totalCount); ?>
                <?php else : ?>
                <h3>
                  <?php echo $this->heading; ?>
                </h3>
                <?php endif; ?>
        </div>
        <div class="fright">
                <?php if (in_array('gridView', $this->viewType)) : ?>
            <span class="seaocore_tab_select_wrapper fright">
                <div class="seaocore_tab_select_view_tooltip"><?php echo $this->translate("Grid View"); ?></div>
                <span class="seaocore_tab_icon tab_icon_grid_view seaocore_tab_icon_<?php echo $this->identity ?>" onclick="sitenewsTabSwitchviewBrowse($(this));" id="gridView" rel='grid_view' ></span>
            </span>
                <?php endif; ?>
                <?php if (in_array('listView', $this->viewType)) : ?>
            <span class="seaocore_tab_select_wrapper fright">
                <div class="seaocore_tab_select_view_tooltip"><?php echo $this->translate("List View"); ?></div>
                <span class="seaocore_tab_icon tab_icon_list_view seaocore_tab_icon_<?php echo $this->identity ?>" onclick="sitenewsTabSwitchviewBrowse($(this));" id="listView" rel='list_view' ></span>
            </span>
                <?php endif; ?>
        </div>
    </div>
    <div id="dynamic_app_info_sitenews_<?php echo $this->identity; ?>">
        <?php endif; ?>
        <?php  if (in_array('gridView', $this->viewType)) :?>
        <div class="sitenews_container" id="grid_view_sitenews_<?php echo $this->identity; ?>" style="<?php echo $this->viewFormat == 'gridView' ? $this->viewFormat : 'display:none;'; ?>">
                <?php include APPLICATION_PATH . '/application/modules/Sitenews/views/scripts/news/_grid_view.tpl'; ?>
        </div>
        <?php endif; ?>
        <?php if (in_array('listView', $this->viewType)) : ?>
        <div class="sitenews_container" id="list_view_sitenews_<?php echo $this->identity; ?>" style="<?php echo $this->viewFormat == 'listView' ? $this->viewFormat : 'display:none;'; ?>">
                <?php include APPLICATION_PATH . '/application/modules/Sitenews/views/scripts/news/_list_view.tpl'; ?>
        </div>
        <?php endif; ?>
        <?php if ($this->showViewMore): ?>    
        <div class="sitenews_blue_button_div_center seaocore_view_more">
                <?php
                echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array(
                    'id' => '',
                    'class' => ''
                ))
                ?>
        </div>
        <?php endif;  ?>    
        <div class="seaocore_loading" style="display: none;">
            <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Seaocore/externals/images/core/loading.gif' style='margin-right: 5px;' />
            <?php echo $this->translate("Loading ...") ?>
        </div>
        <?php if (empty($this->is_ajax)) : ?>
    </div>
</div>
<script lang="javascript">
    var View = function ()
    {
        this.selectedViewFormat = '';
        this.addBoldClass = function ()
        {
            $$('.seaocore_tab_icon_<?php echo $this->identity ?>').each(function (el) {
                el.removeClass('active');
            });
            if ($(this.selectedViewFormat))
                $(this.selectedViewFormat).addClass('active');
        }
    }
    viewObj = new View();
    viewObj.selectedViewFormat = '<?php echo $this->viewFormat ?>';
    if ($('viewFormat')) {
        $('viewFormat').set('value', viewObj.selectedViewFormat);
    }
    viewObj.addBoldClass();

    function sendAjaxRequestSitenews(params) {
        var url = en4.core.baseUrl + 'widget';
        if (params.requestUrl)
            url = params.requestUrl;

        var request = new Request.HTML({
            url: url,
            data: $merge(params.requestParams, {
                format: 'html',
                subject: en4.core.subject.guid,
                is_ajax: true,
                loaded_by_ajax: false
            }),
            evalScripts: true,
            onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
                if (params.requestParams.page == 1) {
                    params.responseContainer.empty();
                    Elements.from(responseHTML).inject(params.responseContainer);
                } else {
                    var element = new Element('div', {
                        'html': responseHTML
                    });
                    params.responseContainer.getElements('.seaocore_loading').setStyle('display', 'none');
                    if ($$('.sitenews_news_view') && element.getElement('.sitenews_news_view')) {
                        Elements.from(element.getElement('.sitenews_news_view').innerHTML).inject(params.responseContainer.getElement('.sitenews_news_view'));
                    }
                    if ($$('.sitenews_news_grid_view') && element.getElement('.sitenews_news_grid_view')) {
                        Elements.from(element.getElement('.sitenews_news_grid_view').innerHTML).inject(params.responseContainer.getElement('.sitenews_news_grid_view'));
                    }
                    if ($$('.sitenews_list_view') && element.getElement('.sitenews_list_view')) {
                        Elements.from(element.getElement('.sitenews_list_view').innerHTML).inject(params.responseContainer.getElement('.sitenews_list_view'));
                    }

                    if ($$('.sitenews_img_view') && element.getElement('.sitenews_img_view')) {
                        Elements.from(element.getElement('.sitenews_img_view').innerHTML).inject(params.responseContainer.getElement('.sitenews_img_view'));
                    }
                    viewObj.addBoldClass();
                }
                en4.core.runonce.trigger();
                Smoothbox.bind(params.responseContainer);
            }
        });
        en4.core.request.send(request);
    }
    function sitenewsTabSwitchviewBrowse(element) {
        var identity = '<?php echo $this->identity; ?>';
        viewObj.selectedViewFormat = element.get('id');
        if ($('viewFormat')) {
            $('viewFormat').set('value', viewObj.selectedViewFormat);
        }
        viewObj.addBoldClass();
        var type = element.get('rel');
        $('dynamic_app_info_sitenews_' + identity).getElements('.sitenews_container').setStyle('display', 'none');
        $(type + '_sitenews_' + identity).style.display = 'block';
    }
</script>
<?php endif; ?>
<?php if ($this->showContent == 2 || $this->showContent == 3): ?>
<script type="text/javascript">
    en4.core.runonce.add(function () {
        hideViewMoreLink('<?php echo $this->showContent; ?>');
    });
</script>
<?php else: ?>
<script type="text/javascript">
    en4.core.runonce.add(function () {
        var view_more_content = $('dynamic_app_info_sitenews_<?php echo $this->identity ?>').getElements('.seaocore_view_more');
        view_more_content.setStyle('display', 'none');
    });
</script>
    <?php
    echo $this->paginationControl($this->paginator, null, array("pagination/pagination.tpl", "sitenews"), array("orderby" => $this->orderby));
    ?>
<?php endif; ?>

<script type="text/javascript">

    var pageAction = function (page) {
        window.location.href = en4.core.baseUrl + 'sitenews/news/browse/page/' + page + '/viewFormat/' + viewObj.selectedViewFormat;
    }

    function getNextPage() {
        return <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
    }

    function hideViewMoreLink(showContent) {
        if (showContent == 3) {
            var view_more_content = $('dynamic_app_info_sitenews_<?php echo $this->identity ?>').getElements('.seaocore_view_more');
            view_more_content.setStyle('display', 'none');
            var totalCount = '<?php echo $this->paginator->count(); ?>';
            var currentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';

            function doOnScrollLoadNews()
            {
                if (typeof (view_more_content[0].offsetParent) != 'undefined') {
                    var elementPostionY = view_more_content[0].offsetTop;
                } else {
                    var elementPostionY = view_more_content.y;
                }
                if (elementPostionY <= window.getScrollTop() + (window.getSize().y - 40)) {

                    if ((totalCount != currentPageNumber) && (totalCount != 0))
                    {
                        if (en4.core.request.isRequestActive())
                            return;
                        var params = {
                            requestParams:<?php echo json_encode($this->params) ?>,
                            responseContainer: $('dynamic_app_info_sitenews_' +<?php echo sprintf('%d', $this->identity) ?>)
                        }
                        params.requestParams.page =<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>;
                        params.requestParams.content_id = '<?php echo $this->identity ?>';
                        view_more_content.setStyle('display', 'none');
                        params.responseContainer.getElements('.seaocore_loading').setStyle('display', '');
                        sendAjaxRequestSitenews(params);
                    }
                }
            }
            window.onscroll = doOnScrollLoadNews;

        } else if (showContent == 2) {
            var view_more_content = $('dynamic_app_info_sitenews_<?php echo $this->identity ?>').getElements('.seaocore_view_more');
            view_more_content.setStyle('display', '<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->totalCount == 0 ? 'none' : '' ) ?>');
            view_more_content.removeEvents('click');
            view_more_content.addEvent('click', function () {
                if (en4.core.request.isRequestActive())
                    return;
                var params = {
                    requestParams:<?php echo json_encode($this->params) ?>,
                    responseContainer: $('dynamic_app_info_sitenews_' +<?php echo sprintf('%d', $this->identity) ?>)
                };
                params.requestParams.page =<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>;
                params.requestParams.content_id = '<?php echo $this->identity ?>';
                view_more_content.setStyle('display', 'none');
                params.responseContainer.getElements('.seaocore_loading').setStyle('display', '');
                sendAjaxRequestSitenews(params);
            });
        }
    }
</script>

<?php
class Info_Widget extends WP_Widget {
    private $default = array(
        'title' => 'Widget title',
        //'data' => '[{"title": "Tab title", "content": "Tab content"}]',
        'data' => array(
            array('title' => 'Tab title', 'content' => 'Tab content', 'order' => 0)
        )
    );

    function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'info-widget', 'description' => __('The information widget', 'kostenlosspielen') );

        /* Widget control settings. */
        $control_ops = array( 'id_base' => 'info_widget' );

        /* Create the widget. */
        parent::__construct( 'info_widget', __('Info Widget', 'kostenlosspielen'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        if(empty($instance)) {
            return;
        }

        $title = $instance['title'];
        $data = $instance['data'];
        $widgetId = $args['widget_id'];

        if(empty($title) || empty($data)) {
            return;
        }

        $tabTitles = array();
        $tabContents = array();

        //TODO: order by order value
        foreach($data as $tab) {
            array_push($tabTitles, $tab['title']);
            array_push($tabContents, $tab['content']);
        }

        $noTab = count($tabTitles);
        $tabWidth = (float)102.20 / $noTab;
        $tabWidth = 'width: '.$tabWidth.'%;';

        echo $args['before_widget'];
        ?>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="text-uppercase"><?php echo $title?></h4>
            </div>
            <div class = "col-xs-3 col-lg-2">
                <ul class="list-toggle-tab" role="tablist">
                    <?php foreach($tabTitles as $i => $tabTitle): ?>
                        <li class="<?php echo ($i == 0 ? 'active' : '') ?>" role="presentation">
                            <a href="#<?php echo $widgetId.'_tab_'.$i ?>" aria-controls="<?php echo $widgetId.'_tab_'.$i ?>" role="tab" data-toggle="tab">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;<?php echo $tabTitle ?>
                            </a>
                        </li>
                    <?php endforeach?>
                </ul>
            </div>
            <div class = "col-xs-9 col-lg-10">
                <div class="tab-content">
                    <?php foreach($tabContents as $i => $tabContent): ?>
                        <div id="<?php echo $widgetId.'_tab_'.$i ?>" role="tabcontent" class="tab-pane <?php echo ($i == 0 ? 'active' : '') ?>">
                            <?php echo $tabContent ?>
                        </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        //. Title
        $instance['title'] = strip_tags($new_instance['title']);

        //. Data
        $data = array();
        foreach($new_instance['data'] as $d) {
            if(!empty($d['title']) && !empty($d['content'])) {
                array_push($data, $d);
            }
        }
        $instance['data'] = $data;

        return $instance;
    }

    function form($instance) {
        /* Set up some default widget settings. */
        $instance = wp_parse_args( (array) $instance, $this->default );

        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <!-- Process data -->
        <div class="info_widget_tabs">
            <div class="list">
                <?php
                $data = $instance['data'];
                $field_data_id = $this->get_field_id('data');
                $field_data_name = $this->get_field_name('data');
                $count = 0;
                foreach($data as $i => $tab):
                    $count++;
                ?>
                    <div class="info_widget_tab">
                        <hr/>
                        <p>
                            <strong>Tab No.<?php echo $count ?></strong>
                            <a class="info_widget_action_link" action="delete" href="javascript:void(0)" style="float: right"><?php _e('Delete this tab', 'hybrid') ?></a>
                        </p>
                        <p>
                            <label for="<?php echo $field_data_id.'_title_'.$i ?>"><?php _e('Title:', 'hybrid'); ?></label>
                            <input id="<?php echo $field_data_id.'_title_'.$i ?>" name="<?php echo $field_data_name.'['.$i.'][title]' ?>" value="<?php echo $tab['title']; ?>"/>
                        </p>
                        <p>
                            <label for="<?php echo $field_data_id.'_order_'.$i ?>"><?php _e('Order:', 'hybrid'); ?></label>
                            <input id="<?php echo $field_data_id.'_order_'.$i ?>" name="<?php echo $field_data_name.'['.$i.'][order]' ?>" value="<?php echo $tab['order']; ?>" />
                        </p>
                        <p>
                            <textarea class="widefat" rows="5" cols="20" id="<?php echo $field_data_id.'_content_'.$i ?>" name="<?php echo $field_data_name.'['.$i.'][content]' ?>"><?php echo $tab['content'] ?></textarea>
                        </p>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
            <!-- TAB template -->
            <div class="widget_tab_template" style="display: none">
                <hr/>
                <p>
                    <strong class="tab_no">Tab No. #NUMBER</strong>
                    <a class="info_widget_action_link" action="delete" href="javascript:void(0)" style="float: right"><?php _e('Delete this tab', 'hybrid') ?></a>
                </p>
                <p>
                    <label for="<?php echo $field_data_id.'_title_#NUMBER' ?>"><?php _e('Title:', 'hybrid'); ?></label>
                    <input id="<?php echo $field_data_id.'_title_#NUMBER' ?>" name="<?php echo $field_data_name.'[#NUMBER][title]' ?>" value=""/>
                </p>
                <p>
                    <label for="<?php echo $field_data_id.'_order_#NUMBER' ?>"><?php _e('Order:', 'hybrid'); ?></label>
                    <input id="<?php echo $field_data_id.'_order_#NUMBER' ?>" name="<?php echo $field_data_name.'[#NUMBER][order]' ?>" value="0" />
                </p>
                <p>
                    <textarea class="widefat" rows="5" cols="20" id="<?php echo $field_data_id.'_content_#NUMBER' ?>" name="<?php echo $field_data_name.'[#NUMBER][content]' ?>"></textarea>
                </p>
            </div>

            <div class="info_widget_more_tab">
                <a class="info_widget_action_link" action="more" href="javascript:void(0)" style="float: right"><?php _e('Add more tab', 'hybrid')?></a>
            </div>
        </div>
        <script type="text/javascript">
            TAB_COUNT = <?php echo ++$count ?>;
            jQuery(document).ready(function($){
                $('a.info_widget_action_link').off('click').on('click', function(e){
                    var $target = $(e.target || e.srcElement);
                    var $tab = $target.closest('div.info_widget_tab');
                    var $tabs = $target.closest('div.info_widget_tabs')
                    var $list = $tabs.find('div.list');
                    var action = $target.attr('action');
                    if(action == 'delete') {
                        $tab.remove();
                    } else if(action == 'more') {
                        var no = TAB_COUNT;
                        TAB_COUNT++;

                        var $template = $tabs.find('div.widget_tab_template');
                        var $tab = $template.clone(true);

                        //. CSS class
                        $tab.removeClass('widget_tab_template').addClass('info_widget_tab');

                        //Tab No. #NUMBER
                        var $no =  $tab.find('strong.tab_no');
                        $no.html($no.html().replace('#NUMBER', no));

                        //. Label
                        $tab.find('label').each(function(index){
                            var $this = $(this);
                            var f = $this.attr('for');
                            f = f.replace('#NUMBER', no);
                            $this.attr('for', f);
                        });

                        //. Input
                        $tab.find('input').each(function(index){
                            var $this = $(this);
                            var id = $this.attr('id');
                            id = id.replace('#NUMBER', no);
                            $this.attr('id', id);

                            var name = $this.attr('name');
                            name = name.replace('#NUMBER', no);
                            $this.attr('name', name);
                        });

                        //. TextArea
                        $tab.find('textarea').each(function(index){
                            var $this = $(this);
                            var id = $this.attr('id');
                            id = id.replace('#NUMBER', no);
                            $this.attr('id', id);

                            var name = $this.attr('name');
                            name = name.replace('#NUMBER', no);
                            $this.attr('name', name);
                        });


                        $tab.appendTo($list);

                        $tab.show();
                    }
                });
            });
        </script>
        <?php
    }
}

function register_tabable_text_widget() {
    register_widget( 'Info_Widget' );
}
add_action( 'widgets_init', 'register_tabable_text_widget');
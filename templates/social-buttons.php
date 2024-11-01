<?php

    // Prevent public access to this script
    defined( 'ABSPATH' ) or die();
    
    ?>
        <style>
            .wpo365-flex-align {
                display: flex;
                display: -webkit-box;
                display: -moz-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                -webkit-box-align: center;
                -moz-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
            }

            .wpo365-social-buttons 
            .wpo365-social-button {
                padding: 3px;
                position: relative;
                height: 36px;
            }

            .wpo365-social-buttons 
            .wpo365-social-button
            #yj-share-button {
                height: 30px !important;
            }

            .wpo365-social-buttons 
            .wpo365-social-button
            .yj-default-share-button {
                height: 30px !important;
                display: flex !important;
                display: -webkit-box !important;
                display: -moz-box !important;
                display: -webkit-flex !important;
                display: -ms-flexbox !important;
                -webkit-box-align: center !important;
                -moz-box-align: center !important;
                -ms-flex-align: center !important;
                -webkit-align-items: center !important;
                align-items: center !important;
            }

            .wpo365-social-buttons 
            .wpo365-social-button 
            .wpo365-social-button-stt {
                background: #3469BA;
                padding: 2px;
                border-radius: 2px;
                height: 30px;
                line-height: 30px;
            }

            .wpo365-social-buttons 
            .wpo365-social-button 
            .wpo365-social-button-stt
            img {
                width: 16px;
                height: 16px;
            }

            .wpo365-social-button-stt::after {
                font-size: 11px;
                font-weight: bold;
                font-family: Helvetica;
                line-height: 11px;
                padding: 0px 4px;
                color: #fff;
                cursor: pointer;
                content: 'Share';
            }

            /* Tooltip text */
            .wpo365-social-buttons 
            .wpo365-social-button
            .tooltiptext {
                visibility: hidden;
                font-size: 11px;
                font-family: Helvetica;
                line-height: 11px;
                color: #3469BA !important;
                padding: 4px 0;
                white-space: nowrap;
                position: absolute;
                z-index: 1;
                top: -18px;
            }

            /* Show the tooltip text when you mouse over the tooltip container */
            .wpo365-social-buttons 
            .wpo365-social-button:hover .tooltiptext {
                visibility: visible;
            }
        </style>
        <div class="wpo365-social-buttons wpo365-flex-align">
            <?php if ( $stt ) : ?>
            
            <!-- Share to Teams -->
            <div class="wpo365-social-button wpo365-flex-align">
                <div
                    class="teams-share-button wpo365-social-button-stt wpo365-flex-align"
                    data-href="<?php echo $current_url ?>"
                    data-icon-px-size="16">
                </div>
                <div class="tooltiptext"><?php _e( 'Share to Teams', 'wpo365-login') ?></div>
            </div>

            <?php endif ?>

            <?php if ( $sty ) : ?>

            <div class="wpo365-social-button wpo365-flex-align">
                <span id="yj-share-button" class="wpo365-flex-align"></span>
                <div class="tooltiptext"><?php _e( 'Share to Yammer', 'wpo365-login') ?></div>
            </div>

            <?php endif ?>
        </div>
{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>

    <div class="button_back">                          
        <a href="{BASE_URL}/admin/member/invite_wallpost_config" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div> 

        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
            <div class="response"></div>
            <div id='calendar' style=" width: 700px; margin: 0 auto;"></div>
            </div>
     
          </div>
        </div>
                 
{/block}
                
{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_wallpost.js"></script>

  
    

    <style>
     .fc button,
 .fc table,
 body .fc {
     font-size: 1em
 }
 
 .fc-bg,
 .fc-row .fc-bgevent-skeleton,
 .fc-row .fc-highlight-skeleton {
     bottom: 0
 }
 
 .fc-icon,
 .fc-unselectable {
     -webkit-touch-callout: none;
     -khtml-user-select: none
 }
 
 .fc {
     direction: ltr;
     text-align: left
 }
 
 .fc-rtl {
     text-align: right
 }
 
 .fc th,
 .fc-basic-view td.fc-week-number,
 .fc-icon,
 .fc-toolbar {
     text-align: center
 }
 
 .fc-highlight {
     background: #bce8f1;
     opacity: .3
 }
 
 .fc-bgevent {
     background: #8fdf82;
     opacity: .3
 }
 
 .fc-nonbusiness {
     background: #d7d7d7
 }
 
 .fc button {
     -moz-box-sizing: border-box;
     -webkit-box-sizing: border-box;
     box-sizing: border-box;
     margin: 0;
     height: 2.1em;
     padding: 0 .6em;
     white-space: nowrap;
     cursor: pointer
 }
 
 .fc button::-moz-focus-inner {
     margin: 0;
     padding: 0
 }
 
 .fc-state-default {
     border: 1px solid;
     background-color: #f5f5f5;
     background-image: -moz-linear-gradient(top, #fff, #e6e6e6);
     background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fff), to(#e6e6e6));
     background-image: -webkit-linear-gradient(top, #fff, #e6e6e6);
     background-image: -o-linear-gradient(top, #fff, #e6e6e6);
     background-image: linear-gradient(to bottom, #fff, #e6e6e6);
     background-repeat: repeat-x;
     border-color: #e6e6e6 #e6e6e6 #bfbfbf;
     border-color: rgba(0, 0, 0, .1) rgba(0, 0, 0, .1) rgba(0, 0, 0, .25);
     color: #333;
     text-shadow: 0 1px 1px rgba(255, 255, 255, .75);
     box-shadow: inset 0 1px 0 rgba(255, 255, 255, .2), 0 1px 2px rgba(0, 0, 0, .05)
 }
 
 .fc-state-default.fc-corner-left {
     border-top-left-radius: 4px;
     border-bottom-left-radius: 4px
 }
 
 .fc-state-default.fc-corner-right {
     border-top-right-radius: 4px;
     border-bottom-right-radius: 4px
 }
 
 .fc button .fc-icon {
     position: relative;
     top: -.05em;
     margin: 0 .2em;
     vertical-align: middle
 }
 
 .fc-state-active,
 .fc-state-disabled,
 .fc-state-down,
 .fc-state-hover {
     color: #333;
     background-color: #e6e6e6
 }

 .fc-state-hover {
     color: #333;
     text-decoration: none;
     background-position: 0 -15px;
     -webkit-transition: background-position .1s linear;
     -moz-transition: background-position .1s linear;
     -o-transition: background-position .1s linear;
     transition: background-position .1s linear
 }
 
 .fc-state-active,
 .fc-state-down {
     background-color: #ccc;
     background-image: none;
     box-shadow: inset 0 2px 4px rgba(0, 0, 0, .15), 0 1px 2px rgba(0, 0, 0, .05)
 }
 
 .fc-state-disabled {
     cursor: default;
     background-image: none;
     opacity: .65;
     box-shadow: none
 }
 
 .fc-event.fc-draggable,
 .fc-event[href],
 .fc-popover .fc-header .fc-close,
 a[data-goto] {
     cursor: pointer
 }
 
 .fc-button-group {
     display: inline-block
 }
 
 .fc .fc-button-group>* {
     float: left;
     margin: 0 0 0 -1px
 }
 
 .fc .fc-button-group>:first-child {
     margin-left: 0
 }
 
 .fc-popover {
     position: absolute;
     box-shadow: 0 2px 6px rgba(0, 0, 0, .15)
 }
 
 .fc-popover .fc-header {
     padding: 2px 4px
 }
 
 .fc-popover .fc-header .fc-title {
     margin: 0 2px
 }
 
 .fc-ltr .fc-popover .fc-header .fc-title,
 .fc-rtl .fc-popover .fc-header .fc-close {
     float: left
 }
 
 .fc-ltr .fc-popover .fc-header .fc-close,
 .fc-rtl .fc-popover .fc-header .fc-title {
     float: right
 }
 
 .fc-divider {
     border-style: solid;
     border-width: 1px
 }
 
 hr.fc-divider {
     height: 0;
     margin: 0;
     padding: 0 0 2px;
     border-width: 1px 0
 }
 
 .fc-bg table,
 .fc-row .fc-bgevent-skeleton table,
 .fc-row .fc-highlight-skeleton table {
     height: 100%
 }
 
 .fc-clear {
     clear: both
 }
 
 .fc-bg,
 .fc-bgevent-skeleton,
 .fc-helper-skeleton,
 .fc-highlight-skeleton {
     position: absolute;
     top: 0;
     left: 0;
     right: 0
 }
 
 .fc table {
     width: 100%;
     box-sizing: border-box;
     table-layout: fixed;
     border-collapse: collapse;
     border-spacing: 0
 }
 
 .fc td,
 .fc th {
     border-style: solid;
     border-width: 1px;
     padding: 0;
     vertical-align: top
 }
 
 .fc td.fc-today {
     border-style: double
 }
 
 a[data-goto]:hover {
     text-decoration: underline
 }
 
 .fc .fc-row {
     border-style: solid;
     border-width: 0
 }
 
 .fc-row table {
     border-left: 0 hidden transparent;
     border-right: 0 hidden transparent;
     border-bottom: 0 hidden transparent
 }
 
 .fc-row:first-child table {
     border-top: 0 hidden transparent
 }
 
 .fc-row {
     position: relative
 }
 
 .fc-row .fc-bg {
     z-index: 1
 }
 
 .fc-row .fc-bgevent-skeleton td,
 .fc-row .fc-highlight-skeleton td {
     border-color: transparent
 }
 
 .fc-row .fc-bgevent-skeleton {
     z-index: 2
 }
 
 .fc-row .fc-highlight-skeleton {
     z-index: 3
 }
 
 .fc-row .fc-content-skeleton {
     position: relative;
     z-index: 4;
     padding-bottom: 2px
 }
 
 .fc-row .fc-helper-skeleton {
     z-index: 5
 }
 
 .fc .fc-row .fc-content-skeleton table,
 .fc .fc-row .fc-content-skeleton td,
 .fc .fc-row .fc-helper-skeleton td {
     background: 0 0;
     border-color: transparent
 }
 
 .fc-row .fc-content-skeleton td,
 .fc-row .fc-helper-skeleton td {
     border-bottom: 0
 }
 
 .fc-row .fc-content-skeleton tbody td,
 .fc-row .fc-helper-skeleton tbody td {
     border-top: 0
 }
 
 .fc-scroller {
     -webkit-overflow-scrolling: touch
 }
 
 .fc-icon,
 .fc-row.fc-rigid,
 .fc-times-grid-event {
     overflow: hidden
 }
 
 .fc-scroller>.fc-day-grid,
 .fc-scroller>.fc-times-grid {
     position: relative;
     width: 100%
 }
 
 .fc-event {
     position: relative;
     display: block;
     font-size: .85em;
     line-height: 1.3;
     border-radius: 3px;
     border: 1px solid #3a87ad
 }
 
 .fc-event,
 .fc-event-dot {
     background-color: #3a87ad
 }
 
 .fc-event,
 .fc-event:hover {
     color: #fff;
     text-decoration: none
 }
 
 .fc-not-allowed,
 .fc-not-allowed .fc-event {
     cursor: not-allowed
 }
 
 .fc-event .fc-bg {
     z-index: 1;
     background: #fff;
     opacity: .25
 }
 
 .fc-event .fc-content {
     position: relative;
     z-index: 2
 }
 
 .fc-event .fc-resizer {
     position: absolute;
     z-index: 4;
     display: none
 }
 .fc-time{
  display: none;
 }
 .fc-event.fc-allow-mouse-resize .fc-resizer,
 .fc-event.fc-selected .fc-resizer {
     display: block
 }
 
 .fc-event.fc-selected .fc-resizer:before {
     content: "";
     position: absolute;
     z-index: 9999;
     top: 50%;
     left: 50%;
     width: 40px;
     height: 40px;
     margin-left: -20px;
     margin-top: -20px
 }
 
 .fc-event.fc-selected {
     z-index: 9999!important;
     box-shadow: 0 2px 5px rgba(0, 0, 0, .2)
 }
 
 .fc-event.fc-selected.fc-dragging {
     box-shadow: 0 2px 7px rgba(0, 0, 0, .3)
 }
 
 .fc-h-event.fc-selected:before {
     content: "";
     position: absolute;
     z-index: 3;
     top: -10px;
     bottom: -10px;
     left: 0;
     right: 0
 }
 
 .fc-ltr .fc-h-event.fc-not-start,
 .fc-rtl .fc-h-event.fc-not-end {
     margin-left: 0;
     border-left-width: 0;
     padding-left: 1px;
     border-top-left-radius: 0;
     border-bottom-left-radius: 0
 }
 
 .fc-ltr .fc-h-event.fc-not-end,
 .fc-rtl .fc-h-event.fc-not-start {
     margin-right: 0;
     border-right-width: 0;
     padding-right: 1px;
     border-top-right-radius: 0;
     border-bottom-right-radius: 0
 }
 
 .fc-ltr .fc-h-event .fc-start-resizer,
 .fc-rtl .fc-h-event .fc-end-resizer {
     cursor: w-resize;
     left: -1px
 }
 
 .fc-ltr .fc-h-event .fc-end-resizer,
 .fc-rtl .fc-h-event .fc-start-resizer {
     cursor: e-resize;
     right: -1px
 }
 
 .fc-h-event.fc-allow-mouse-resize .fc-resizer {
     width: 7px;
     top: -1px;
     bottom: -1px
 }
 
 .fc-h-event.fc-selected .fc-resizer {
     border-radius: 4px;
     border-width: 1px;
     width: 6px;
     height: 6px;
     border-style: solid;
     border-color: inherit;
     background: #fff;
     top: 50%;
     margin-top: -4px
 }
 
 .fc-ltr .fc-h-event.fc-selected .fc-start-resizer,
 .fc-rtl .fc-h-event.fc-selected .fc-end-resizer {
     margin-left: -4px
 }
 
 .fc-ltr .fc-h-event.fc-selected .fc-end-resizer,
 .fc-rtl .fc-h-event.fc-selected .fc-start-resizer {
     margin-right: -4px
 }
 
 .fc-day-grid-event {
     margin: 1px 2px 0;
     padding: 0 1px
 }
 
 tr:first-child>td>.fc-day-grid-event {
     margin-top: 2px
 }
 
 .fc-day-grid-event.fc-selected:after {
     content: "";
     position: absolute;
     z-index: 1;
     top: -1px;
     right: -1px;
     bottom: -1px;
     left: -1px;
     background: #000;
     opacity: .25
 }
 
 .fc-day-grid-event .fc-content {
     white-space: normal;
     overflow: hidden
 }
 
 .fc-day-grid-event .fc-times {
     font-weight: 700
 }
 
 .fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer,
 .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer {
     margin-left: -2px
 }
 
 .fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer,
 .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer {
     margin-right: -2px
 }
 
 a.fc-more {
     margin: 1px 3px;
     font-size: .85em;
     cursor: pointer;
     text-decoration: none
 }
 
 a.fc-more:hover {
     text-decoration: underline
 }
 
 .fc.fc-bootstrap3 a,
 .ui-widget .fc-event {
     text-decoration: none
 }
 
 .fc-limited {
     display: none
 }
 
 .fc-icon,
 .fc-toolbar .fc-center {
     display: inline-block
 }
 
 .fc-day-grid .fc-row {
     z-index: 1
 }
 
 .fc-more-popover {
     z-index: 2;
     width: 220px
 }
 
 .fc-more-popover .fc-event-container {
     padding: 10px
 }
 
 .fc-bootstrap3 .fc-popover .panel-body,
 .fc-bootstrap4 .fc-popover .card-body {
     padding: 0
 }
 
 .fc-now-indicator {
     position: absolute;
     border: 0 solid red
 }
 
 .fc-bootstrap3 .fc-today.alert,
 .fc-bootstrap4 .fc-today.alert {
     border-radius: 0
 }
 
 .fc-unselectable {
     -webkit-user-select: none;
     -moz-user-select: none;
     -ms-user-select: none;
     user-select: none;
     -webkit-tap-highlight-color: transparent
 }
 
 .fc-unthemed .fc-content,
 .fc-unthemed .fc-divider,
 .fc-unthemed .fc-list-heading td,
 .fc-unthemed .fc-list-view,
 .fc-unthemed .fc-popover,
 .fc-unthemed .fc-row,
 .fc-unthemed tbody,
 .fc-unthemed td,
 .fc-unthemed th,
 .fc-unthemed thead {
     border-color: #ddd
 }
 
 .fc-unthemed .fc-popover {
     background-color: #fff;
     border-width: 1px;
     border-style: solid
 }
 
 .fc-unthemed .fc-divider,
 .fc-unthemed .fc-list-heading td,
 .fc-unthemed .fc-popover .fc-header {
     background: #eee
 }
 
 .fc-unthemed td.fc-today {
     background: #fcf8e3
 }
 
 .fc-unthemed .fc-disabled-day {
     background: #d7d7d7;
     opacity: .3
 }
 
 .fc-icon {
     height: 1em;
     line-height: 1em;
     font-size: 1em;
     font-family: "Courier New", Courier, monospace;
     -webkit-user-select: none;
     -moz-user-select: none;
     -ms-user-select: none;
     user-select: none
 }
 
 .fc-icon:after {
     position: relative
 }
 
 .fc-icon-left-single-arrow:after {
     content: "\2039";
     font-weight: 700;
     font-size: 200%;
     top: -7%
 }
 
 .fc-icon-right-single-arrow:after {
     content: "\203A";
     font-weight: 700;
     font-size: 200%;
     top: -7%
 }
 
 .fc-icon-left-double-arrow:after {
     content: "\AB";
     font-size: 160%;
     top: -7%
 }
 
 .fc-icon-right-double-arrow:after {
     content: "\BB";
     font-size: 160%;
     top: -7%
 }
 
 .fc-icon-left-triangle:after {
     content: "\25C4";
     font-size: 125%;
     top: 3%
 }
 
 .fc-icon-right-triangle:after {
     content: "\25BA";
     font-size: 125%;
     top: 3%
 }
 
 .fc-icon-down-triangle:after {
     content: "\25BC";
     font-size: 125%;
     top: 2%
 }
 
 .fc-icon-x:after {
     content: "\D7";
     font-size: 200%;
     top: 6%
 }
 
 .fc-unthemed .fc-popover .fc-header .fc-close {
     color: #666;
     font-size: .9em;
     margin-top: 2px
 }
 
 .fc-unthemed .fc-list-item:hover td {
     background-color: #f5f5f5
 }
 
 .ui-widget .fc-disabled-day {
     background-image: none
 }
 
 .fc-bootstrap3 .fc-times-grid .fc-slats table,
 .fc-bootstrap4 .fc-times-grid .fc-slats table,
 .fc-times-grid .fc-slats .ui-widget-content {
     background: 0 0
 }
 
 .fc-popover>.ui-widget-header+.ui-widget-content {
     border-top: 0
 }
 
 .fc-bootstrap3 hr.fc-divider,
 .fc-bootstrap4 hr.fc-divider {
     border-color: inherit
 }
 
 .ui-widget .fc-event {
     color: #fff;
     font-weight: 400
 }
 
 .ui-widget td.fc-axis {
     font-weight: 400
 }
 
 .fc.fc-bootstrap3 a[data-goto]:hover {
     text-decoration: underline
 }
 
 .fc.fc-bootstrap4 a {
     text-decoration: none
 }
 
 .fc.fc-bootstrap4 a[data-goto]:hover {
     text-decoration: underline
 }
 
 .fc-bootstrap4 a.fc-event:not([href]):not([tabindex]) {
     color: #fff
 }
 
 .fc-bootstrap4 .fc-popover.card {
     position: absolute
 }
 
 .fc-toolbar.fc-header-toolbar {
     margin-bottom: 1em
 }
 
 .fc-toolbar.fc-footer-toolbar {
     margin-top: 1em
 }
 
 .fc-toolbar .fc-left {
     float: left
 }
 
 .fc-toolbar .fc-right {
     float: right
 }
 
 .fc .fc-toolbar>*>* {
     float: left;
     margin-left: .75em
 }
 
 .fc .fc-toolbar>*>:first-child {
     margin-left: 0
 }
 
 .fc-toolbar h2 {
     margin: 0
 }
 
 .fc-toolbar button {
     position: relative
 }
 
 .fc-toolbar .fc-state-hover,
 .fc-toolbar .ui-state-hover {
     z-index: 2
 }
 
 .fc-toolbar .fc-state-down {
     z-index: 3
 }
 
 .fc-toolbar .fc-state-active,
 .fc-toolbar .ui-state-active {
     z-index: 4
 }
 
 .fc-toolbar button:focus {
     z-index: 5
 }
 
 .fc-view-container *,
 .fc-view-container:after,
 .fc-view-container:before {
     -webkit-box-sizing: content-box;
     -moz-box-sizing: content-box;
     box-sizing: content-box
 }
 
 .fc-view,
 .fc-view>table {
     position: relative;
     z-index: 1
 }
 
 .fc-basicDay-view .fc-content-skeleton,
 .fc-basicWeek-view .fc-content-skeleton {
     padding-bottom: 1em
 }
 
 .fc-basic-view .fc-body .fc-row {
     min-height: 4em
 }
 
 .fc-row.fc-rigid .fc-content-skeleton {
     position: absolute;
     top: 0;
     left: 0;
     right: 0
 }
 
 .fc-day-top.fc-other-month {
     opacity: .3
 }
 
 .fc-basic-view .fc-day-number,
 .fc-basic-view .fc-week-number {
     padding: 2px
 }
 
 .fc-basic-view th.fc-day-number,
 .fc-basic-view th.fc-week-number {
     padding: 0 2px
 }
 
 .fc-ltr .fc-basic-view .fc-day-top .fc-day-number {
     float: right
 }
 
 .fc-rtl .fc-basic-view .fc-day-top .fc-day-number {
     float: left
 }
 
 .fc-ltr .fc-basic-view .fc-day-top .fc-week-number {
     float: left;
     border-radius: 0 0 3px
 }
 
 .fc-rtl .fc-basic-view .fc-day-top .fc-week-number {
     float: right;
     border-radius: 0 0 0 3px
 }
 
 .fc-basic-view .fc-day-top .fc-week-number {
     min-width: 1.5em;
     text-align: center;
     background-color: #f2f2f2;
     color: grey
 }
 
 .fc-basic-view td.fc-week-number>* {
     display: inline-block;
     min-width: 1.25em
 }
 
 .fc-agenda-view .fc-day-grid {
     position: relative;
     z-index: 2
 }
 
 .fc-agenda-view .fc-day-grid .fc-row {
     min-height: 3em
 }
 
 .fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
     padding-bottom: 1em
 }
 
 .fc .fc-axis {
     vertical-align: middle;
     padding: 0 4px;
     white-space: nowrap
 }
 
 .fc-ltr .fc-axis {
     text-align: right
 }
 
 .fc-rtl .fc-axis {
     text-align: left
 }
 
 .fc-times-grid,
 .fc-times-grid-container {
     position: relative;
     z-index: 1
 }
 
 .fc-times-grid {
     min-height: 100%
 }
 
 .fc-times-grid table {
     border: 0 hidden transparent
 }
 
 .fc-times-grid>.fc-bg {
     z-index: 1
 }
 
 .fc-times-grid .fc-slats,
 .fc-times-grid>hr {
     position: relative;
     z-index: 2
 }
 
 .fc-times-grid .fc-content-col {
     position: relative
 }
 
 .fc-times-grid .fc-content-skeleton {
     position: absolute;
     z-index: 3;
     top: 0;
     left: 0;
     right: 0
 }
 
 .fc-times-grid .fc-business-container {
     position: relative;
     z-index: 1
 }
 
 .fc-times-grid .fc-bgevent-container {
     position: relative;
     z-index: 2
 }
 
 .fc-times-grid .fc-highlight-container {
     z-index: 3;
     position: relative
 }
 
 .fc-times-grid .fc-event-container {
     position: relative;
     z-index: 4
 }
 
 .fc-times-grid .fc-now-indicator-line {
     z-index: 5
 }
 
 .fc-times-grid .fc-helper-container {
     position: relative;
     z-index: 6
 }
 
 .fc-times-grid .fc-slats td {
     height: 1.5em;
     border-bottom: 0
 }
 
 .fc-times-grid .fc-slats .fc-minor td {
     border-top-style: dotted
 }
 
 .fc-times-grid .fc-highlight {
     position: absolute;
     left: 0;
     right: 0
 }
 
 .fc-ltr .fc-times-grid .fc-event-container {
     margin: 0 2.5% 0 2px
 }
 
 .fc-rtl .fc-times-grid .fc-event-container {
     margin: 0 2px 0 2.5%
 }
 
 .fc-times-grid .fc-bgevent,
 .fc-times-grid .fc-event {
     position: absolute;
     z-index: 1
 }
 
 .fc-times-grid .fc-bgevent {
     left: 0;
     right: 0
 }
 
 .fc-v-event.fc-not-start {
     border-top-width: 0;
     padding-top: 1px;
     border-top-left-radius: 0;
     border-top-right-radius: 0
 }
 
 .fc-v-event.fc-not-end {
     border-bottom-width: 0;
     padding-bottom: 1px;
     border-bottom-left-radius: 0;
     border-bottom-right-radius: 0
 }
 
 .fc-times-grid-event.fc-selected {
     overflow: visible
 }
 
 .fc-times-grid-event.fc-selected .fc-bg {
     display: none
 }
 
 .fc-times-grid-event .fc-content {
     overflow: hidden
 }
 
 .fc-times-grid-event .fc-times,
 .fc-times-grid-event .fc-title {
     padding: 0 1px
 }
 
 .fc-times-grid-event .fc-times {
     font-size: .85em;
     white-space: nowrap
 }
 
 .fc-times-grid-event.fc-short .fc-content {
     white-space: nowrap
 }
 
 .fc-times-grid-event.fc-short .fc-times,
 .fc-times-grid-event.fc-short .fc-title {
     display: inline-block;
     vertical-align: top
 }
 
 .fc-times-grid-event.fc-short .fc-times span {
     display: none
 }
 
 .fc-times-grid-event.fc-short .fc-times:before {
     content: attr(data-start)
 }
 
 .fc-times-grid-event.fc-short .fc-times:after {
     content: "\A0-\A0"
 }
 
 .fc-times-grid-event.fc-short .fc-title {
     font-size: .85em;
     padding: 0
 }
 
 .fc-times-grid-event.fc-allow-mouse-resize .fc-resizer {
     left: 0;
     right: 0;
     bottom: 0;
     height: 8px;
     overflow: hidden;
     line-height: 8px;
     font-size: 11px;
     font-family: monospace;
     text-align: center;
     cursor: s-resize
 }
 
 .fc-times-grid-event.fc-allow-mouse-resize .fc-resizer:after {
     content: "="
 }
 
 .fc-times-grid-event.fc-selected .fc-resizer {
     border-radius: 5px;
     border-width: 1px;
     width: 8px;
     height: 8px;
     border-style: solid;
     border-color: inherit;
     background: #fff;
     left: 50%;
     margin-left: -5px;
     bottom: -5px
 }
 
 .fc-times-grid .fc-now-indicator-line {
     border-top-width: 1px;
     left: 0;
     right: 0
 }
 
 .fc-times-grid .fc-now-indicator-arrow {
     margin-top: -5px
 }
 
 .fc-ltr .fc-times-grid .fc-now-indicator-arrow {
     left: 0;
     border-width: 5px 0 5px 6px;
     border-top-color: transparent;
     border-bottom-color: transparent
 }
 
 .fc-rtl .fc-times-grid .fc-now-indicator-arrow {
     right: 0;
     border-width: 5px 6px 5px 0;
     border-top-color: transparent;
     border-bottom-color: transparent
 }
 
 .fc-event-dot {
     display: inline-block;
     width: 10px;
     height: 10px;
     border-radius: 5px
 }
 
 .fc-rtl .fc-list-view {
     direction: rtl
 }
 
 .fc-list-view {
     border-width: 1px;
     border-style: solid
 }
 
 .fc .fc-list-table {
     table-layout: auto
 }
 
 .fc-list-table td {
     border-width: 1px 0 0;
     padding: 8px 14px
 }
 
 .fc-list-table tr:first-child td {
     border-top-width: 0
 }
 
 .fc-list-heading {
     border-bottom-width: 1px
 }
 
 .fc-list-heading td {
     font-weight: 700
 }
 
 .fc-ltr .fc-list-heading-main {
     float: left
 }
 
 .fc-ltr .fc-list-heading-alt,
 .fc-rtl .fc-list-heading-main {
     float: right
 }
 
 .fc-rtl .fc-list-heading-alt {
     float: left
 }
 
 .fc-list-item.fc-has-url {
     cursor: pointer
 }
 
 .fc-list-item-marker,
 .fc-list-item-time {
     white-space: nowrap;
     width: 1px
 }
 
 .fc-ltr .fc-list-item-marker {
     padding-right: 0
 }
 
 .fc-rtl .fc-list-item-marker {
     padding-left: 0
 }
 
 .fc-list-item-title a {
     text-decoration: none;
     color: inherit
 }
 
 .fc-list-item-title a[href]:hover {
     text-decoration: underline
 }
 
 .fc-list-empty-wrap2 {
     position: absolute;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0
 }
 
 .fc-list-empty-wrap1 {
     width: 100%;
     height: 100%;
     display: table
 }
 
 .fc-list-empty {
     display: table-cell;
     vertical-align: middle;
     text-align: center
 }
 
 .fc-unthemed .fc-list-empty {
     background-color: #eee
 }
    </style>




<script src="{$PUBLIC_URL}javascript/fullcalendar/lib/moment.min.js" type="text/javascript"></script>

  <script src="{$PUBLIC_URL}/javascript/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>

    


     
    <script>
$(document).ready(function () {

    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "member/fetchevent",
        displayEventTime: true,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = true;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
              var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                var end =moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD')
           
                $.ajax({
                    url: '{$BASE_URL}admin/member/addevent',
                    
                     data: {
                        {$CSRF_TOKEN_NAME}: "{$CSRF_TOKEN_VALUE}",
                        title:title, 
                        start:start,
                        end:end,
                    },
                    type: "POST",
                    success: function (data) {
                    window.reload();

                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        
        editable: true,
        eventDrop: function (event, delta) {

                    var start = moment(event.start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var end = moment(event.end, 'DD.MM.YYYY').format('YYYY-MM-DD');
 console.log(event);

                    $.ajax({

                        url: 'member/editevent',
                        data: {
                        {$CSRF_TOKEN_NAME}: "{$CSRF_TOKEN_VALUE}",
                        title:event.title, 
                        start:start,
                        end:end,
                        id:event.id,                        
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
        eventClick: function (event) {

            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "member/deleteevent",
                    data:{ 
                    {$CSRF_TOKEN_NAME}: "{$CSRF_TOKEN_VALUE}",
                    id:event.id,
                    },
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }

    });
});

function displayMessage(message) {
        $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>
{/block}
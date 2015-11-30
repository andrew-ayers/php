<?php
    /*
     * See: https://google-developers.appspot.com/chart/
     *
     * Google Chart types supported by this handler include:
     *
     *     Area
     *     Bar
     *     Bubble
     *     Candlestick
     *     Column
     *     Combo
     *     Gauge
     *     Geo
     *     Histogram
     *     Line
     *     Maps
     *     Pie
     *     Scatter (including trendlines)
     *     Stepped Area
     *     Treemap
     *
     * The following Google Chart types are not currently supported:
     *
     *     Annotation
     *     Calendar
     *     Diff
     *     Intervals
     *     Organizational
     *     Sankey Diagram
     *     Table
     *     Timeline
     */
    class chart_handler {
        public function __construct() {
            $request = $_REQUEST;

            $data = $this->_parse_request($request);

            $this->_output_data($data);
        }

        private function _parse_request($request) {
            if ($request["id"] == 12345) {
                $data = array(
                    array('Sample', 'Dataset 1', 'Dataset 2')
                );

                for ($i = 0; $i < 100; $i++) {
                    $inbound = rand(0, 100);
                    $outbound = rand(0, 100);

                    $data[] = array($i, $inbound, $outbound);
                }

                $data = array('data' => $data);
            }

            return $data;
        }

        private function _output_data($data) {
            $data = json_encode($data);

            echo $data;
        }
    }

    /*
     * Instantiate and execute google chart data handler (AJAX)
     */
    $test = new chart_handler();
?>
<?php
include("header.php");
include("simple_html_dom.php");
include("vendor/autoload.php");

function getFtseCurrent()
{

    $page = [];


    $url = "https://uk.finance.yahoo.com/q?s=^ftse";
    $html = new simple_html_dom();
    $html->load_file($url);
    $start = $html->find("span[id=yfs_l10_^ftse]", 0);
    $page["ftse100_price"] = $start->plaintext;
    // $ftse100_price
    $movement = $html->find("span[id=yfs_c10_^ftse]", 0);
    $page["ftse100_move"] = $movement->plaintext;
    // ftse100_move
    $change = $html->find("span[id=yfs_p20_^ftse]", 0);
    $page["ftse100_percent_change"] = $change->plaintext;
    // $ftse100_percent_change
    $prevClose = $html->find("td[class=yfnc_tabledata1]", 0);
    $page["ftse100_previous_close"] = $prevClose->plaintext;
    // ftse100_previous_close

    $url = "https://uk.finance.yahoo.com/q?s=^ftmc";
    $html = new simple_html_dom();
    $html->load_file($url);
    $start = $html->find("span[id=yfs_l10_^ftmc]", 0);
    $page["ftse250_price"] = $start->plaintext;
    // $ftse100_price
    $movement = $html->find("span[id=yfs_c10_^ftmc]", 0);
    $page["ftse250_move"] = $movement->plaintext;
    // ftse100_move
    $change = $html->find("span[id=yfs_p20_^ftmc]", 0);
    $page["ftse250_percent_change"] = $change->plaintext;
    // $ftse100_percent_change
    $prevClose = $html->find("td[class=yfnc_tabledata1]", 0);
    $page["ftse250_previous_close"] = $prevClose->plaintext;
    // ftse100_previous_close

    return $page;
}

$pageData = getFtseCurrent();
foreach ($pageData as $key => $value) {
    $$key = $value;
}

?>

    <section id="ftse-billboard" class="jumbotron billboard parallax">
        <div class="background artwork"></div>
        <div class="background overlay"></div>
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 text-center text-primary m-t-none m-b">FTSE Ventures</h1>

                <h2 class="col-xs-12 text-center m-t-none m-b-xl">Beta Version 1</h2>

                <h2 class="col-xs-12 text-center m-t-none m-b">To view the Github repository click <a
                        href="https://github.com/matterson11/ftseventures_draft_1" target="_blank">here</a>.
                </h2>

            </div>
        </div>
    </section>
    <section class="content-stripe">
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 text-center text-primary m-t-none m-b"><a
                        href="https://github.com/matterson11/ftseventures_draft_1" target="_blank">FTSE
                        Ventures</a></h1>
                <hr class="col-xs-6 col-xs-offset-3 m-t-xs p-none">
                <div class="col-md-6">
                    <h2 class="col-xs-12 text-center m-t-none m-b">FTSE Ventures tries to predict the movements of
                        companies
                        listed on the FTSE 100 & 250 Indexes.</h2>
                    <p class="col-xs-12 text-center m-t-none m-b-xl">This is the first Beta and simply a proof of
                        concept.
                        The next significant stage is building a tracking system so that we can monitor how accurate the
                        predictions are.</p>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="center">FTSE 100 - <span><?php echo $ftse100_price; ?></span></h3>
                            <h4>
                                <?php
                                if ($ftse100_price > $ftse100_previous_close) { ?>
                                    <span class="decrease"></span>
                                    <span class="increase"> + <?php echo $ftse100_move ?></span>
                                    <span class="decrease"></span>
                                    <span class="increase"> <?php echo $ftse100_percent_change ?></span>
                                    <?php
                                }
                                if ($ftse100_price < $ftse100_previous_close) {
                                    ?>
                                    <span class="decrease"></span>
                                    <span class="decrease"> - <?php echo $ftse100_move ?></span>
                                    <span class="decrease"></span>
                                    <span class="decrease"> <?php echo $ftse100_percent_change ?></span>
                                    <?php
                                }
                                ?>
                            </h4>
                            <table class="table_data">
                                <tr>
                                    <th>Symbol</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>% Change</th>
                                </tr>
                                <?php
                                $url = "https://uk.finance.yahoo.com/q?s=^ftse";
                                $html = new simple_html_dom();
                                $html->load_file($url);

                                $tables = $html->find('table');
                                foreach ($tables[3]->find('tr') as $j => $rows) {
                                    /*if ($j > 0) {*/
                                    echo "<tr>";
                                    foreach ($rows->find("td") as $i => $bodies) {
                                        if ($i == 0) {
                                            $symbol = $bodies->plaintext;
                                            $symbol = str_replace('.L', '', $symbol);

                                            echo "<td>$symbol</td>";
                                            $client = new Scheb\YahooFinanceApi\ApiClient();
                                            try {
                                                $data = $client->getQuotes("$symbol.L");

                                                $name = $data["query"]["results"]["quote"]["Name"];

                                                ?>
                                                <td><?php echo $name ?></td>

                                                <?php
                                            } catch
                                            (Exception $ex) {
                                                echo "<td>$name</td>";
                                            }
                                        }
                                        if ($i == 1) {
                                            $price = $bodies->plaintext;
                                            echo "<td>$price</td>";
                                        }
                                        if ($i == 2) {
                                            $percent = $bodies->plaintext;
                                            //echo "<td>$percent</td>";
                                            $client = new Scheb\YahooFinanceApi\ApiClient();

                                            try {
                                                $data = $client->getQuotes("$symbol.L");

                                                $current_price = $price;
                                                $previous_close = $data["query"]["results"]["quote"]["PreviousClose"];

                                                if ($price > $previous_close) { ?>
                                                    <td class="increase"> ( <?php echo $percent ?>)</td>
                                                    <?php
                                                }
                                                if ($price < $previous_close) {
                                                    ?>
                                                    <td class="decrease"> ( <?php echo $percent ?>)</td>
                                                    <?php
                                                }
                                            } catch (Exception $ex) {
                                                echo "<td>$percent</td>";
                                            }

                                        }
                                    }
                                    /*  } */
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="content-stripe">
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 text-center text-primary m-t-none m-b">How it works?</h1>
                <hr class="col-xs-6 col-xs-offset-3 m-t-xs p-none">
                <h2 class="col-xs-12 text-center m-t-none m-b">The algorithm looks at four key market factors when
                    calculating an individual companies buy/sell rating. 10 being a very strong buy and 1 being a drop
                    what you’re doing and sell now.</h2>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                    <h2 class="text-primary text-center m-t">Director Dealing Activity</h2>
                    <p class="text-center m-b-lg">Using the open source simple_html_dom.php script, the site uses a web
                        crawler to gather data on large trades being made by directors. From this data it provides a
                        score based on the number and value of trades made in a 30-day period.</p>
                    <p class="col-xs-12 text-center m-t-none m-b-xl"><a
                            href="https://github.com/matterson11/ftseventures_draft_1/blob/master/DirectorDealingController.php"
                            target="_blank">DirectorDealingsController.php</a>
                    </p>
                </div>
                <div class="col-md-3 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                    <h2 class="text-primary text-center m-t">20 & 50 Day Moving Average</h2>
                    <p class="text-center m-b-lg">The most common method in Algorithm trading. It’s widely accepted that
                        if a company’s 50 day moving average is higher than its 200 day moving average, then law of
                        averages assumes the company’s market value will rise. Based on the size difference between the
                        two categories, a rating is calculated.</p>
                    <p class="col-xs-12 text-center m-t-none m-b-xl"><a
                            href="https://github.com/matterson11/ftseventures_draft_1/blob/master/MovingAverageController.php"
                            target="_blank">MovingAverageController.php</a></p>
                </div>
                <div class="col-md-3 col-md-offset-0 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <h2 class="text-primary text-center m-t">Analyst Ratings</h2>
                    <p class="text-center m-b-lg">Investment Analysts give their opinion on the company trends by
                        providing a company with any of the Strong-buy, Buy, Hold, Underperform, Sell predictions. The
                        Web
                        Crawler (Simple_html_dom.php) gathers this data into a Controller which then calculates which
                        way the trend is facing, updates our database and provides a rating.</p>
                    <p class="col-xs-12 text-center m-t-none m-b-xl"><a
                            href="https://github.com/matterson11/ftseventures_draft_1/blob/master/MarketAnalysisController.php"
                            target="_blank">MarketAnalysisController.php</a></p>
                </div>
                <div class="col-md-3 col-md-offset-0 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <h2 class="text-primary text-center m-t">Price Expectations</h2>
                    <p class="text-center m-b-lg">Analysts also calculate what they see as the company’s market value.
                        From these forecasts the mean market value is calculated and, based on the difference between
                        the company’s current market value and the mean value set by analyst expectations, a rating is
                        produced.</p>
                    <p class="col-xs-12 text-center m-t-none m-b-xl"><a
                            href="https://github.com/matterson11/ftseventures_draft_1/blob/master/PriceTargetController.php"
                            target="_blank">PriceTargetController.php</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="content-stripe">
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 text-center text-primary m-t-none m-b">Construction and Design</h1>
                <hr class="col-xs-6 col-xs-offset-3 m-t-xs p-none">
                <p class="col-xs-12 text-center m-t-none m-b-xl">I had intended to build inside the Laravel framework
                    from the beginning, but what started out as building the code to test features eventually turned
                    into a fully operational model and the snowball effect set in. The next stage is taking the project
                    and transfering to the Laravel Framework.</p>
                <p class="col-xs-12 text-center m-t-none m-b-xl">Controllers are automatically called multiple times a
                    day to gather information, as referenced above, and update the MySQL database.</p>
                <p class="col-xs-12 text-center m-t-none m-b-xl">HTML, CSS, Bootstrap and Jquery are used for front end
                    functionality and design.</p>
            </div>
        </div>
    </section>
    <section class="content-stripe">
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 text-center text-primary m-t-none m-b">What's next?</h1>
                <hr class="col-xs-6 col-xs-offset-3 m-t-xs p-none">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <ol class="text-justify m-b-lg">
                    <li class="text-primary m-b-sm"><span class="text-default">Build a tracker system that follows the
                            week’s top 5 winners and losers for proof of concept</span>
                    </li>
                    <li class="text-primary m-b-sm"><span class="text-default">Add company financials ie Debt, Revenue,
                            Net Income etc…</span>
                    </li>
                    <li class="text-primary m-b-sm"><span class="text-default">Add a blog page</span>
                    </li>
                </ol>
            </div>
        </div>
    </section>


<?php
include("footer.php");
?>
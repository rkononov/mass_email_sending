<?php
include(__DIR__ . '/../lib/IronWorkerWrapper.php');
$num_emails = $_REQUEST['num_emails'];
$name = "emailWorker.php";

$start = get_time();
queue_worker($iw, $name,$num_emails);
$worker_time = get_time() - $start;
$details = array("worker" => $worker_time);
echo json_encode($details);

function get_time()
{
    return (float)array_sum(explode(' ', microtime()));
}

function queue_worker($iw, $name,$num_emails)
{
    ob_start();
    $tmpdir = $_SERVER['TMP_DIR'];
    if (empty($tmpdir)) {
        $tmpdir = dirname(__FILE__);
    }
    $zipName = $tmpdir . "/$name.zip";
        $file = IronWorker::zipDirectory(dirname(__FILE__) . "/../workers", $zipName, true);
        $res = $iw->postCode('emailWorker.php', $zipName, $name);
    $tasks = array();
    for ($i = 1; $i <= $num_emails/10; $i++)
    {
        $payload = array('num_emails' => 10);
        $task_id = $iw->postTask($name, $payload);
    }

    do {
        $details = $iw->getTaskDetails($task_id);#waiting for a last task
        $queued_or_running = array("running","queued");
    } while (in_array($details->status , $queued_or_running));
    ob_end_clean();
}

?>

<?php

echo CJSON::encode(array(
	'status' => $status,
	'message' => $message,
	'data' => isset($data) ? $data : null,
), false);
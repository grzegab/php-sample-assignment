<?php

$tokenInfo = file_get_contents('https://api.supermetrics.com/assignment/register?client_id=ju16a6m81mhid5ue1z3v2g0uh&email=my@name.com&name=My%20Name');

/**
 * Comments to PR:
 * 1. Why email is hardcoded (should it be in separate variable)
 * 2. Why name hardcoded (should it be in separate variable)
 * 3. Why file_get_contents, why not curl
 * 4. Why no check for failure
 */
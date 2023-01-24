<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/firestore/README.md
 */

namespace Google\Cloud\Samples\Firestore;

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Transaction;

/**
 * Run a simple transaction.
 *
 * @param string $projectId The Google Cloud Project ID
 */
function transaction_document_update(string $projectId): void
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START firestore_transaction_document_update]
    $cityRef = $db->collection('samples/php/cities')->document('SF');
    $db->runTransaction(function (Transaction $transaction) use ($cityRef) {
        $snapshot = $transaction->snapshot($cityRef);
        $newPopulation = $snapshot['population'] + 1;
        $transaction->update($cityRef, [
            ['path' => 'population', 'value' => $newPopulation]
        ]);
    });
    # [END firestore_transaction_document_update]
    print('Ran a simple transaction to update the population field in the SF document in the cities collection.');
    print(PHP_EOF);
}

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);

<?php
/*
 *
 * Copyright 2015 gRPC authors.
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
 *
 */

// php:generate protoc --proto_path=./../protos   --php_out=./   --grpc_out=./ --plugin=protoc-gen-grpc=./../../bins/opt/grpc_php_plugin ./../protos/helloworld.proto

require '../vendor/autoload.php';

require_once '../PHPGen/Helloworld/GreeterClient.php';
require_once '../PHPGen/Helloworld/HelloReply.php';
require_once '../PHPGen/Helloworld/HelloRequest.php';
require_once '../PHPGen/GPBMetadata/Helloworld.php';

function greet($name)
{
    $client = new Helloworld\GreeterClient('grpcserver:50051', [
        'credentials' => Grpc\ChannelCredentials::createInsecure(),
    ]);
    $request = new Helloworld\HelloRequest();
    $request->setName($name);
    list($reply, $status) = $client->SayHello($request)->wait();
    $message = $reply->getMessage();

    return $message;
}

$name = !empty($argv[1]) ? $argv[1] : 'jopa';
echo greet($name)."\n";

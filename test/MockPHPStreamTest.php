<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

class MockPHPStreamTest extends TestCase
{
    public function test()
    {
        $param = '';
        $s = new MockPHPStream();

        $s->stream_open($param, $param, $param, $param);
        $s->stream_close();
        $s->stream_stat();
        $s->stream_flush();
        $s->stream_read(1);
        $s->stream_eof();
        $s->stream_write('t e s t');
        $s->unlink();
    }
}

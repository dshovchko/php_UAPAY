<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

class MockPHPStreamTest
{
    public function test()
    {
        $s = new MockPHPStream();
        $s->stream_open('', '', '', '');
        $s->stream_close();
        $s->stream_stat();
        $s->stream_flush();
        $s->stream_read(1);
        $s->stream_eof();
        $s->stream_write('t e s t');
        $s->unlink();
    }
}

<?php

test('example', function () {
    expect(true)->toBeTrue();
});

test('http test', function () {
    $this->get('/')->assertOk();
});

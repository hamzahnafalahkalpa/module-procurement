<?php

test('example', function () {
    expect(true)->toBeTrue();
});

test('try', function () {
    expect(1)->toBe(1);
});

test('std class', function () {
    expect(new stdClass)->not()->toBe(new stdClass);
});

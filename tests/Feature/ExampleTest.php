<?php

it('redirects root route to login for unauthenticated user', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

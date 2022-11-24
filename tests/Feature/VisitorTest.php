<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Visitor;
use App\Models\User;

class VisitorTest extends TestCase
{
    //Index methods
    public function test_not_authorised_user_is_redirected_from_visitors(){
        //I have changed assertRouteIs to assertViewIs. Check if ok. 
        $this->followingRedirects()->get('/visitors')->assertViewIs('auth.login');
    }

    public function test_authorised_user_can_see_visitors()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
        ->get('/visitors');
        $response->assertOk();

        $response->assertViewIs('visitors.index');
        $expectedPage1NameData = Visitor::orderBy('created_at', 'desc')
        ->take(20)
        ->pluck('comments');
        
        $response->assertSeeInOrder(array_merge([
            'All of our visitors'
        ], $expectedPage1NameData->toArray()));
    }

    //Show methods
    public function test_not_authorised_user_is_redirected_from_visitor(){
        $visitor = Visitor::factory()->create();
        $this->followingRedirects()->get("/visitors/{$visitor->id}")->assertViewIs('auth.login');
    }

    public function test_authorised_wrong_user_cannot_see_visitor(){
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $wrongUser = User::factory()->create();

        $response = $this->followingRedirects()->actingAs($wrongUser)->get("/visitors/{$visitor->id}");
        $response->assertForbidden();
    }

    public function test_authorised_user_can_see_visitor()
    {
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $response = $this->followingRedirects()->actingAs($visitor->user)->get("/visitors/{$visitor->id}");
        $response->assertOk();
        
        $this->assertEquals($newComments, $visitor->comments);
    }

    //Edit methods
    public function test_not_authorised_user_is_redirected_from_edit_visitor(){
        $visitor = Visitor::factory()->create();
        $this->followingRedirects()->get("/visitors/{$visitor->id}/edit")->assertViewIs('auth.login');
    }

    public function test_authorised_wrong_user_cannot_see_edit_visitor(){
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $wrongUser = User::factory()->create();

        $response = $this->followingRedirects()->actingAs($wrongUser)->get("/visitors/{$visitor->id}/edit");
        $response->assertForbidden();
    }

    public function test_authorised_user_can_edit_visitor()
    {
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $response = $this->actingAs($visitor->user)->followingRedirects()->get("/visitors/{$visitor->id}/edit");
        $response->assertOk();
        
        $this->assertEquals($newComments, $visitor->comments); 
    }

    //Update methods
    public function test_not_authorised_user_recieves_401_for_update(){
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $response = $this->followingRedirects()->put("/visitors/{$visitor->id}",['comments'=>$newComments]);
        $newVisitor = $visitor->fresh();
        $response->assertUnauthorized();
        $this->assertNotEquals($newComments, $newVisitor->comments);
    }

    public function test_authorised_wrong_user_recieves_403_for_update(){
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;
        $wrongUser = User::factory()->create();

        $response = $this->followingRedirects()->actingAs($wrongUser)->put("/visitors/{$visitor->id}",['comments' => $newComments]);
        $response->assertForbidden();
    }

    /*public function test_update_visitors_wrong_user() {
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $wrongUser = User::factory()->create();
        
        $response = $this->actingAs($wrongUser)
        ->followingRedirects()
        ->patch("/visitors/{$visitor->id}", [
            'comments' => $newComments
        ]);
        
        $newVisitor = $visitor->fresh();
        $response->assertUnauthorized();
        $this->assertNotEquals($newComments, $newVisitor->comments);
    }*/

    public function test_authorised_user_can_update_visitor()
    {
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        
        $response = $this->actingAs($visitor->user)
        ->followingRedirects()
        ->patch("/visitors/{$visitor->id}", [
            'comments' => $newComments
        ]);
        
        $newVisitor = $visitor->fresh();
        $response->assertOk();
        $this->assertEquals($newComments, $newVisitor->comments);
    }

    public function test_incomplete_data_fails_validation_for_update()
    {
        $user = User::factory()->create();
        $visitor = Visitor::factory()->create();

        $response = $this->actingAs($visitor->user)->put("/visitors/{$visitor->id}",['comments' => '']);
        $response->assertSessionHasErrors(['comments']);
    }

    //Destroy methods
    public function test_not_authorised_user_recieves_401_for_delete(){
        $user = User::factory()->create();
        $newComments = 'test comments for 403 unauthorised delete';
        $visitor = Visitor::factory()->create([
            'comments' => $newComments,
            'user_id' => $user->id
        ]);

        $response = $this->followingRedirects()->delete("/visitors/{$visitor->id}");
        
        $response->assertUnauthorized();
        $this->assertDatabaseHas('visitors',['user_id' => $visitor->user_id, 'comments' => $newComments]);
        
    }

    public function test_not_authorised_user_recieves_403_for_delete(){
        $user = User::factory()->create();
        $newComments = 'test comments for 403 unauthorised delete';
        $visitor = Visitor::factory()->create([
            'comments' => $newComments,
            'user_id' => $user->id
        ]);

        $wrongUser = User::factory()->create();

        $response = $this->followingRedirects()->actingAs($wrongUser)->delete("/visitors/{$visitor->id}");
        $response->assertForbidden();
        $this->assertDatabaseHas('visitors',['user_id' => $user->id, 'comments' => $newComments]);
        
    }

    public function test_authorised_user_can_delete_note(){
        $user = User::factory()->create();
        $newComments = 'Some test comments';
        $visitor = Visitor::factory()->create();
        $visitor->comments = $newComments;

        $response = $this->actingAs($visitor->user)->followingRedirects()->delete("/visitors/{$visitor->id}");
        $response->assertOk();

        $this->assertDatabaseMissing('visitors',['id' => $visitor->id]);
    }

    //Create methods
    public function test_not_authorised_user_is_redirected_from_create_form(){
        $this->followingRedirects()->get('/visitors/create')->assertViewIs('auth.login');
    }

    public function test_authorised_user_can_render_create_form(){
        $user = User::factory()->create();

        //assertRouteIs has been removed from $response.
        $response =$this->followingRedirects()->actingAs($user)->get('visitors/create');
        $response->assertOk();

        //need to assert the response includes the form HTML
    }

    //Store methods
    public function test_not_authorised_user_receives_401_for_store(){
        $newComment = 'test comment that does not exist.';

        $response = $this->followingRedirects()->post('/visitors',['comments'=>$newComment]);
        $response->assertUnauthorized();
        
        $this->assertDatabaseMissing('visitors',['comments' => $newComment]);
    }

    public function test_authorised_user_can_create_note(){
        $user = User::factory()->create();
        $newComment = 'test comment';

        $response =$this->followingRedirects()->actingAs($user)->post('/visitors',['comments' => $newComment]);
        $response->assertOk();

        $this->assertDatabaseHas('visitors',['user_id' => $user->id, 'comments' => $newComment]);
    }

    public function test_incomplete_data_validation_for_store(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/visitors', ['comments' => '']);
        $response->assertSessionHasErrors(['comments']);
    }

}

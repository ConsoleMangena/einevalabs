<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use Tests\TestCase;

class PublicPagesRenderTest extends TestCase
{
    public function test_home_page_renders_with_correct_copy(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // The H1 wording changes as the positioning evolves, so this asserts the
        // structural invariant rather than a literal: the glitch effect animates
        // the data-text layer, so those two must always be identical.
        $content = $response->getContent();

        preg_match('/<h1[^>]*data-text="([^"]*)"[^>]*>(.*?)<\/h1>/s', $content, $m);

        $this->assertNotEmpty($m, 'Home page H1 with data-text was not found.');
        $this->assertSame(
            $m[1],
            trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES)),
            'H1 data-text and visible text must match or the glitch effect animates a different phrase.'
        );

        $response->assertSee('technology research lab', false);
    }

    public function test_ethics_page_renders(): void
    {
        $response = $this->get('/ethics');

        $response->assertStatus(200);
    }

    /**
     * The three departments are sections on one page rather than their own
     * routes, so this asserts all three headings render together.
     */
    public function test_services_page_renders_all_three_departments(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Cybersecurity', false);
        $response->assertSee('Software Engineering', false);
        // Asserted against config so a rename in one place does not break this test.
        $response->assertSee(e(config('departments.three_d.label')), false);

        // One per department, so the CSS accent can key off data-dept.
        $response->assertSee('data-dept="cyber"', false);
        $response->assertSee('data-dept="software"', false);
        $response->assertSee('data-dept="three_d"', false);
    }

    public function test_services_page_renders_new_department_services(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        // Software engineering
        $response->assertSee('API &amp; Backend Systems', false);
        $response->assertSee('Maintenance &amp; Support', false);
        // 3D & motion
        $response->assertSee('Interactive 3D &amp; WebGL', false);
        $response->assertSee('3D Modelling &amp; Asset Creation', false);
        // Cybersecurity content survives the restructure.
        $response->assertSee('Penetration Testing', false);
    }

    public function test_contact_form_offers_every_department(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('name="department"', false);

        foreach (config('departments') as $department) {
            $response->assertSee('value="'.$department['slug'].'"', false);
        }
    }

    public function test_department_label_resolves_through_config(): void
    {
        // Asserted against config rather than a literal so renaming a capability in
        // config/departments.php does not require editing this test.
        $this->assertSame(
            config('departments.three_d.label'),
            (new ContactSubmission(['department' => 'three_d']))->departmentLabel()
        );
        $this->assertNull((new ContactSubmission)->departmentLabel());
    }
}

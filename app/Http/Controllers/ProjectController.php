<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectAddLeaderRequest;
use App\Http\Requests\ProjectTaskAddParticipantRequest;
use App\Http\Requests\ProjectDeleteLeaderRequest;
use App\Http\Requests\ProjectTaskDeleteParticipantRequest;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectDeleteRequest;
use App\Http\Requests\ProjectEditRequest;
use App\Models\Project;
use App\Models\ProjectParticipant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function view()
    {
        $data = array();
        $projects = Project::all();

        foreach ($projects as $project) {
            $project->participants = ProjectParticipant::where('project_id', $project->id)->get();

            foreach ($project->participants as $participant) {
                $participant->user = User::where('id', $participant->user_id)->first();
            }
        }

        $data['projects'] = $projects;
        return view('pages.projects.view', $data);
    }

    /**
     * @param ProjectCreateRequest $request
     * @return \Illuminate\View\View
     */
    public function createProject(ProjectCreateRequest $request) {
        $project = Project::create([
            "title" => $request->input("project-title"),
            "description" => $request->input("project-desc"),
            "profile_picture" => $request->input("project-img") != null ? $request->input("project-img") : 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png', // TODO: Make local
            "creator_id" => auth()->user()->id,
        ]);

        ProjectParticipant::create([
            'project_id' => $project->id,
            'user_id' => auth()->user()->id,
            'leader' => true
        ]);

        return $this->view();
    }

    /**
     * @param ProjectEditRequest $request
     * @return \Illuminate\View\View
     */
    public function editProject(ProjectEditRequest $request) {
        // TODO: Check if is owner or leader of project
        $project = Project::where('id', $request->input('project-id'))->first();

        $project->title = $request->input('project-title');
        $project->description = $request->input('project-desc');
        $project->profile_picture = $request->input('project-img');
        $project->save();

        return $this->view();
    }

    /**
     * @param ProjectDeleteRequest $request
     * @return \Illuminate\View\View
     */
    public function deleteProject(ProjectDeleteRequest $request) {
        // TODO: Check if is owner or leader of project
        Project::where('id', $request->input('project-id'))->first()->delete();

        return $this->view();
    }

    /**
     * @param $projectid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewDetails($projectid) {
        $data = array();
        $data['project'] = $project = Project::where('id', $projectid)->first();
        $data['creator'] = $creator = User::where('id', $project->creator_id)->first();
        $participants = ProjectParticipant::where('project_id', $projectid)->get();

        foreach ($participants as $participant) {
            $participant->user = User::where('id', $participant->user_id)->first();
        }
        $data['participants'] = $participants;

        return view('pages.projects.viewDetails', $data);
    }

    /**
     * @param ProjectAddLeaderRequest $request
     * @param $projectid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addLeader(ProjectAddLeaderRequest $request, $projectid) {
        error_log($request->input('leader-mail'));
        $participant = User::where('email', $request->input('leader-mail'))->first();

        if ($participant == null) {
            return back()->withStatus(__('There is no participant with this email-address.'));
        }

        ProjectParticipant::create([
            'project_id' => $projectid,
            'user_id' => $participant->id,
            'leader' => true
        ]);

        return redirect()->route('project.view', ['projectid' => $projectid]);
    }

    /**
     * @param ProjectDeleteLeaderRequest $request
     * @param $projectid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteLeader(ProjectDeleteLeaderRequest $request, $projectid) {
        ProjectParticipant::where('id', $request->input('leader-id'))->delete();
        return redirect()->route('project.view', ['projectid' => $projectid]);
    }

    /**
     * @param ProjectTaskAddParticipantRequest $request
     * @param $projectid
     */
    public function addParticipant(ProjectTaskAddParticipantRequest $request, $projectid): \Illuminate\Http\RedirectResponse
    {
        $participant = User::where('email', $request->input('participant-mail'))->first();

        if ($participant == null) {
            return back()->withStatus(__('There is no participant with this email-address.'));
        }

        ProjectParticipant::create([
            'project_id' => $projectid,
            'user_id' => $participant->id,
            'leader' => false
        ]);

        return redirect()->route('project.view', ['projectid' => $projectid]);
    }

    /**
     * @param ProjectTaskDeleteParticipantRequest $request
     * @param $projectid
     */
    public function deleteParticipant(ProjectTaskDeleteParticipantRequest $request, $projectid): \Illuminate\Http\RedirectResponse
    {
        ProjectParticipant::where('id', $request->input('participant-id'))->delete();
        return redirect()->route('project.view', ['projectid' => $projectid]);
    }
}

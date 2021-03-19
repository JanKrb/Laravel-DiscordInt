<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTaskAddParticipantRequest;
use App\Http\Requests\ProjectTaskAnswerRequest;
use App\Http\Requests\ProjectTaskDeleteParticipantRequest;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectTaskAnswer;
use App\Models\ProjectTaskAssignment;
use App\Models\ProjectTaskStatus;
use App\Models\ProjectTaskStatusAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use function GuzzleHttp\Promise\task;

class BoardController extends Controller
{

    /**
     * Show the form for editing the profile.
     * @param $projectid
     * @param $boardid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewList($projectid)
    {
        $data = array();
        $tasks = ProjectTask::where('project_id', $projectid)->get();
        foreach ($tasks as $tkey => $task) {
            $statuses = ProjectTaskStatusAssignment::where(['project_id' => $projectid, 'task_id' => $task->id])->get();
            $statuse = array();
            foreach ($statuses as $status) {
                $statuse[] = ProjectTaskStatus::where('id', $status->status_id)->first();
            }
            $task['statuses'] = $statuse;

            if ($task->deadline == null) {
                $task->time_left = array();
                continue;
            }

            $deadline_date = new \DateTime($task->deadline);
            $task->time_left = $deadline_date->diff(now());
        }

        $data['tasks'] = $tasks;
        $data['project_id'] = $projectid;

        return view('pages.boards.viewList', $data);
    }

    /**
     * @param $projectid
     * @param $boardid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewKanban($projectid) {
        return view('pages.boards.viewKanban', ['project_id' => $projectid]);
    }

    /**
     * @param $projectid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewDetail($projectid, $taskid) {
        $data = array();

        $task = ProjectTask::where('id', $taskid)->first();
        $user = User::where('id', $task->user_id)->first();

        $answers = ProjectTaskAnswer::where('task_id', $taskid)->orderBy('created_at', 'DESC')->get();
        foreach ($answers as $answer) {
            $answer->user = User::where('id', $answer->user_id)->first();
        }

        $assignments = ProjectTaskAssignment::where(['project_id' => $projectid, 'task_id' => $taskid])->get();
        foreach ($assignments as $assignment) {
            $assignment->user = User::where('id', $assignment->user_id)->first();
        }

        $data['assignments'] = $assignments;
        $data['project'] = Project::where('id', $projectid)->first();
        $data['status_assigned'] = ProjectTaskStatusAssignment::where('id', $task->status)->all();
        $data['statuses'] = ProjectTaskStatus::all();
        $data['task'] = $task;
        $data['user'] = $user;
        $data['answers'] = $answers;

        return view('pages.boards.viewDetail', $data);
    }

    /**
     * @param ProjectTaskAnswerRequest $request
     */
    public function answerTask(ProjectTaskAnswerRequest $request, $projectid, $taskid) {
        ProjectTaskAnswer::create([
            "project_id" => $projectid,
            "task_id" => $taskid,
            "user_id" => auth()->user()->id,
            "description" => $request->input("answer-text")
        ]);

        return $this->viewDetail($projectid, $taskid);
    }

    /**
     * @param ProjectTaskAddParticipantRequest $request
     * @param $projectid
     * @param $taskid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addParticipant(ProjectTaskAddParticipantRequest $request, $projectid, $taskid) {
        $participant = User::where('email', $request->input('participant-mail'))->first();

        if ($participant == null) {
            return back()->withStatus(__('There is no participant with this email-address.'));
        }

        ProjectTaskAssignment::create([
            'project_id' => $projectid,
            'task_id' => $taskid,
            'user_id' => $participant->id
        ]);

        return redirect()->route('project.view.details', ['projectid' => $projectid, 'taskid' => $taskid]);
    }

    /**
     * @param ProjectTaskDeleteParticipantRequest $request
     * @param $projectid
     * @param $taskid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteParticipant(ProjectTaskDeleteParticipantRequest $request, $projectid, $taskid) {
        ProjectTaskAssignment::where('id', $request->input('participant-id'))->delete();
        return redirect()->route('project.view.details', ['projectid' => $projectid, 'taskid' => $taskid]);
    }

    public function updateStatus() {

    }
}

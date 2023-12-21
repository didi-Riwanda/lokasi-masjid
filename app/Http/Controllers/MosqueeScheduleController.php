<?php

namespace App\Http\Controllers;

use App\Models\Mosquee;
use App\Models\MosqueeSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MosqueeScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Mosquee $mosquee, Request $request)
    {
        $model = $mosquee->schedules()->select([
            'id',
            'start_time',
            'end_time',
            'duration',
            'day',
            'title',
            'type',
            'speakers',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('mosquee.schedule.index', [
            'mosquee' => $mosquee,
            'paginate' => [
                'data' => $paginator->items(),
                'meta' => [
                    'count' => $paginator->count(),
                    'next' => optional($paginator->nextCursor())->encode(),
                    'previous' => optional($paginator->previousCursor())->encode(),
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Mosquee $mosquee)
    {
        return view('mosquee.schedule.create', [
            'mosquee' => $mosquee,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Mosquee $mosquee, Request $request)
    {
        return DB::transaction(function () use ($mosquee, $request) {
            $startTime = Carbon::parse($request->start_time);
            $endTime = Carbon::parse($request->end_time);
            $days = [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ];

            $day = null;
            if (in_array($request->type, ['kajian', 'tahsin', 'tahfidz']) && in_array($request->day, $days)) {
                $day = $request->day;
            } else if (in_array($request->type, ['dauroh'])) {
                $day = strtolower($startTime->format('l'));
            }

            $mosquee->schedules()->create([
                'title' => $request->input('title'),
                'speakers' => $request->input('speakers'),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'day' => $day,
                'type' => $request->input('type'),
                'duration' => $endTime->diffInSeconds($startTime),
            ]);

            return redirect()->route(
                'mosquee.schedule.index',
                ['mosquee' => $mosquee->uuid],
            )->with('success', 'Successfully');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee $mosquee, MosqueeSchedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee $mosquee, MosqueeSchedule $schedule)
    {
        return view('mosquee.schedule.edit', [
            'mosquee' => $mosquee,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee $mosquee, MosqueeSchedule $schedule)
    {
        return DB::transaction(function () use ($mosquee, $schedule, $request) {
            $startTime = Carbon::parse($request->start_time);
            $endTime = Carbon::parse($request->end_time);
            $days = [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ];

            $day = null;
            if (in_array($request->type, ['kajian', 'tahsin', 'tahfidz']) && in_array($request->day, $days)) {
                $day = $request->day;
            } else if (in_array($request->type, ['dauroh'])) {
                $day = strtolower($startTime->format('l'));
            }

            $schedule->update([
                'title' => $request->input('title'),
                'speakers' => $request->input('speakers'),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'day' => $day,
                'type' => $request->input('type'),
                'duration' => $endTime->diffInSeconds($startTime),
            ]);

            return redirect()->route(
                'mosquee.schedule.index',
                ['mosquee' => $mosquee->uuid],
            )->with('success', 'Successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee $mosquee, MosqueeSchedule $schedule)
    {
        return DB::transaction(function () use ($mosquee, $schedule) {
            optional($mosquee->schedules()->find($schedule->id))->delete();

            return redirect()->route('mosquee.schedule.index', [
                'mosquee' => $mosquee->uuid,
            ]);
        });
    }
}

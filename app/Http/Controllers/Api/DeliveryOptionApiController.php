<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use App\Models\Slot;
use App\Models\CityMapping;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeliveryOptionApiController extends Controller
{
  // show data of DeliveryOption table
  public function list() {
    $deliveryOptions = DeliveryOption::whereStatus(1)->get();
    foreach($deliveryOptions as $key => $option) {
        $test = [];
        $values = explode(',', $option->time_slot_inside);
        foreach($values as $index => $val) {
            $test[$index] = Slot::findOrFail($val);
        }
        $deliveryOptions[$key]['time_slot_inside'] = $test;
    }

    return $deliveryOptions;
   }

  // public function deliveryOptionsByCityOld(Request $request) {
  //   try {
  //     $delay = 0;
  //     if ($request->has('product_id')) {
  //       $delay = productIdDelayCount($request->get('product_id'));
  //     }

  //     $currentDateTime = Carbon::now('Asia/Kolkata');
  //     $currentTime = $currentDateTime->addHour(1 + $delay)->format('H:i');
  //     $currentTime = "10:23";

  //     if ($request->has('city_id')) {
  //       $cityId = $request->get('city_id');
  //       $cityMapping = CityMapping::where('city_id', $cityId)->get();

  //       if ($cityMapping->count() > 0) {
  //         $options = [];

  //         foreach ($cityMapping as $key => $map) {
  //           $options[$key] = $map->deliveryOption;

  //           $test = [];
  //           $values = explode(',', $map->deliveryOption->time_slot_inside);

  //           foreach ($values as $index => $val) {
  //             $slot = Slot::findOrFail($val);
  //             if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
  //               $timeNow = Carbon::createFromFormat('H:i', $currentTime);
  //               $timeTo = Carbon::createFromFormat('H:i', $slot->to);
  //               if ($timeNow->lessThan($timeTo)) {
  //                 $test[] = $slot;
  //               }
  //             } else {
  //               $test[] = $slot;
  //             }
  //           }

  //           $options[$key]['time_slot_inside'] = $test;
  //         }

  //         return response()->json($options);
  //       } else {
  //         $deliveryOptions = DeliveryOption::all();
  //         foreach ($deliveryOptions as $key => $option) {
  //             $test = [];
  //             $values = explode(',', $option->time_slot_inside);

  //             foreach ($values as $index => $val) {
  //                 $slot = Slot::findOrFail($val);
  //                 if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
  //                   $timeNow = Carbon::createFromFormat('H:i', $currentTime);
  //                   $timeTo = Carbon::createFromFormat('H:i', $slot->to);
  //                   if ($timeNow->lessThan($timeTo)) {
  //                     $test[] = $slot;
  //                   }
  //                 } else {
  //                   $test[] = $slot;
  //                 }
  //             }

  //             $deliveryOptions[$key]['time_slot_inside'] = $test;
  //         }
  //         return response()->json($deliveryOptions);
  //       }
  //     } else {
  //       $deliveryOptions = DeliveryOption::all();

  //       foreach ($deliveryOptions as $key => $option) {
  //           $test = [];
  //           $values = explode(',', $option->time_slot_inside);

  //           foreach ($values as $index => $val) {
  //               $slot = Slot::findOrFail($val);
  //               if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
  //                 $timeNow = Carbon::createFromFormat('H:i', $currentTime);
  //                 $timeTo = Carbon::createFromFormat('H:i', $slot->to);
  //                 if ($timeNow->lessThan($timeTo)) {
  //                   $test[] = $slot;
  //                 }
  //               } else {
  //                 $test[] = $slot;
  //               }
  //           }

  //           $deliveryOptions[$key]['time_slot_inside'] = $test;
  //       }
  //       return response()->json($deliveryOptions);
  //     }
  //   } catch (\Exception $e) {
  //     dd($e->getMessage());
  //   }
  // }


  public function deliveryOptionsByCity(Request $request)
  {
      try {
          $delay = 0;
          if ($request->has('product_id')) {
              $delay = productIdDelayCount($request->get('product_id'));
          }

          $currentDateTime = Carbon::now('Asia/Kolkata');
          $currentTime = $currentDateTime->addHour($delay)->format('H:i');
          // $currentTime = "00:01"; //8:30

          if ($request->has('city_id')) {
              $cityId = $request->get('city_id');
              $cityMapping = CityMapping::where('city_id', $cityId)->get();

              if ($cityMapping->count() > 0) {
                  $options = [];

                  foreach ($cityMapping as $key => $map) {
                      $deliveryOption = $map->deliveryOption;

                      if (!empty($deliveryOption->time_slot_inside)) {
                          $test = [];
                          $values = explode(',', $deliveryOption->time_slot_inside);

                          foreach ($values as $index => $val) {
                              $slot = Slot::findOrFail($val);
                              $timeNow = Carbon::createFromFormat('H:i', $currentTime);
                              $timeFrom = Carbon::createFromFormat('H:i', $slot->from);

                              // Additional condition to remove 05:00 - 08:00 slots
                              if (
                                  ($request->get('delivery_date') == $currentDateTime->format('Y-m-d') ||
                                  $request->get('delivery_date') == $currentDateTime->addDay()->format('Y-m-d')) &&
                                  $timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(5, 0)) &&
                                  $timeFrom->lessThan(Carbon::createFromTime(8, 0))
                              ) {
                                  continue;
                              }

                              // Check other conditions to include/exclude slots
                              if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
                                  if ($timeNow->greaterThanOrEqualTo(Carbon::createFromTime(20, 59)) && $timeNow->lessThan(Carbon::createFromTime(23, 59))) {
                                      if ($timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(22, 0)) || $timeFrom->lessThan(Carbon::createFromTime(0, 0))) {
                                          continue;
                                      }
                                  }

                                  if ($timeNow->lessThan($timeFrom)) {
                                      $test[] = $slot;
                                  }
                              } else {
                                  $test[] = $slot;
                              }
                          }

                          if (!empty($test)) {
                              $deliveryOption['time_slot_inside'] = $test;
                              $options[] = $deliveryOption;
                          }
                      }
                  }

                  return response()->json(array_values($options));
              } else {
                  $deliveryOptions = DeliveryOption::whereStatus(1)->get()->reject(function ($option) {
                      return empty($option->time_slot_inside);
                  })->toArray();

                  foreach ($deliveryOptions as $key => $option) {
                      $test = [];
                      $values = explode(',', $option['time_slot_inside']);

                      foreach ($values as $index => $val) {
                          $slot = Slot::findOrFail($val);
                          $timeNow = Carbon::createFromFormat('H:i', $currentTime);
                          $timeFrom = Carbon::createFromFormat('H:i', $slot->from);

                          // Additional condition to remove 05:00 - 08:00 slots
                          if (
                              ($request->get('delivery_date') == $currentDateTime->format('Y-m-d') ||
                              $request->get('delivery_date') == $currentDateTime->addDay()->format('Y-m-d')) &&
                              $timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(5, 0)) &&
                              $timeFrom->lessThan(Carbon::createFromTime(8, 0))
                          ) {
                              continue;
                          }

                          // Check other conditions to include/exclude slots
                          if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
                              if ($timeNow->greaterThanOrEqualTo(Carbon::createFromTime(20, 59)) && $timeNow->lessThan(Carbon::createFromTime(23, 59))) {
                                  if ($timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(22, 0)) || $timeFrom->lessThan(Carbon::createFromTime(0, 0))) {
                                      continue;
                                  }
                              }

                              if ($timeNow->lessThan($timeFrom)) {
                                  $test[] = $slot;
                              }
                          } else {
                              $test[] = $slot;
                          }
                      }

                      if (!empty($test)) {
                          $deliveryOptions[$key]['time_slot_inside'] = $test;
                      } else {
                          unset($deliveryOptions[$key]);
                      }
                      // $deliveryOptions[$key]['time_slot_inside'] = $test;
                  }

                  return response()->json(array_values($deliveryOptions));
              }
          } else {
              $nextDayDateTime = $currentDateTime->clone()->addDay();
              $deliveryOptions = DeliveryOption::whereStatus(1)->get()->reject(function ($option) {
                  return empty($option->time_slot_inside);
              })->toArray();

              foreach ($deliveryOptions as $key => $option) {
                  $test = [];
                  $values = explode(',', $option['time_slot_inside']);

                  foreach ($values as $index => $val) {
                      $slot = Slot::findOrFail($val);
                      $timeNow = Carbon::createFromFormat('H:i', $currentTime);
                      $timeFrom = Carbon::createFromFormat('H:i', $slot->from);

                      // Additional condition to remove 05:00 to 08:00 slots
                      if (
                          ($request->get('delivery_date') == $currentDateTime->format('Y-m-d') ||
                          $request->get('delivery_date') == $nextDayDateTime->format('Y-m-d')) &&
                          $timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(5, 0)) &&
                          $timeFrom->lessThan(Carbon::createFromTime(8, 0))
                      ) {
                          continue;
                      }

                      // Check other conditions to include/exclude slots
                      if ($request->get('delivery_date') == $currentDateTime->format('Y-m-d')) {
                          if ($timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(5, 0)) && $timeFrom->lessThan(Carbon::createFromTime(8, 0))) {
                              continue;
                          }

                          if ($timeNow->greaterThanOrEqualTo(Carbon::createFromTime(20, 59)) && $timeNow->lessThan(Carbon::createFromTime(23, 59))) {
                              if ($timeFrom->greaterThanOrEqualTo(Carbon::createFromTime(22, 0)) || $timeFrom->lessThan(Carbon::createFromTime(0, 0))) {
                                  continue;
                              }
                          }

                          if ($timeNow->lessThan($timeFrom)) {
                              $test[] = $slot;
                          }
                      } else {
                          $test[] = $slot;
                      }
                  }

                  if (!empty($test)) {
                      $deliveryOptions[$key]['time_slot_inside'] = $test;
                  } else {
                      unset($deliveryOptions[$key]);
                  }
              }

              return response()->json(array_values($deliveryOptions));
          }
      } catch (\Exception $e) {
          dd($e->getMessage());
      }
  }









}

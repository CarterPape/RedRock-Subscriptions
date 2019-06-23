<?php

$hmm = 
"mutation {
  couponCreate(
    amountOffCents:7500
    isPercentage:true
    code:''
    couponType:limited
    maximumNumberOfRedemptions:1
    recurringLimit:9
  ) {
    coupon {
      id
      state
    }
  }
}";
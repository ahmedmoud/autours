<template>

    <body>
    <div class="star">

        <input type="radio" id="r1">
        <label for="r1"></label>

        <input type="radio" id="r2">
        <label for="r2"></label>

        <input type="radio"  id="r3">
        <label for="r3"></label>

        <input type="radio" id="r4">
        <label for="r4"></label>

        <input type="radio" id="r5">
        <label for="r5"></label>


    </div>
    </body>

</template>

<script setup>

</script>

<style lang="scss">

@mixin star() {
    $fill: ★;
    $empty: ☆;
    width: 400px;
    > * {
        float: right;
    }

    label {
        height: 50px;
        width: 50px;
        position: relative;
        cursor: pointer;
        padding: 0 10px;
        @for $i from 5 through 1 {
            &:nth-of-type(#{$i}):after {
                animation-delay: $i * .1s;
            }
        }
        &:after {
            transition: all 1s ease-out;
            position: absolute;
            content: '#{$empty}';
            color: orange;
            font-size: 65px;
        }
    }
    input {
        display: none;
        &:checked {
            + label:after,
            ~ label:after {
                content: '#{$fill}';
                color: gold;
                text-shadow: 0 0 10px gold;
            }
        }
    }
}

.star {
    @include star();
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}

.star:hover {
    @include star();
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}
</style>

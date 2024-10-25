@extends('admin.layouts.app')
@section('main')
    @php
        $questions = $submitted_vendor->questions;
        $totalScore = 0;

        foreach ($questions as $question) {
            $answer = $question->userAnswer($user->id);

            if ($answer) {
                $totalScore += $answer->score;
            }
        }
    @endphp

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active"> Submitted Vendors</li>
                    <li class="breadcrumb-item active"> Show</li>
                </ol>
            </nav>
        </div>
        <section class="container mt-5">
            <h2 class="text-end mb-4">Total Score: {{ $totalScore }}</h2>

            <div class="container">
                <h1 class="text-center">Vendor Report Spider Diagram</h1>
                <svg></svg> <!-- SVG canvas for the D3 graph -->
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script>
        var width = 960,
            height = 600,
            root;

        var force = d3.layout.force()
            .linkDistance(200)
            .charge(-200)
            .gravity(0)
            .size([width, height])
            .on("tick", tick);

        var svg = d3.select("svg")
            .attr("width", width)
            .attr("height", height);

        var link = svg.selectAll(".link"),
            node = svg.selectAll(".node");

        // Load the JSON data
        d3.json("{{ route('admin.graph.data') }}", function(error, json) {
            if (error) throw error;
            root = json;
            update();
        });

        function update() {
            var nodes = flatten(root),
                links = d3.layout.tree().links(nodes);

            // Restart the force layout.
            force
                .nodes(nodes)
                .links(links)
                .start();

            // Update links.
            link = link.data(links, function(d) { return d.target.id; });

            link.exit().remove();

            link.enter().insert("line", ".node")
                .attr("class", "link");

            // Update nodes.
            node = node.data(nodes, function(d) { return d.id; });

            node.exit().remove();

            var nodeEnter = node.enter().append("g")
                .attr("class", "node")
                .on("click", click)
                .call(force.drag);

            nodeEnter.append("svg:a")
                .attr("xlink:href", function(d){ return d.link; })
                .append("circle")
                .attr("r", function(d) { return Math.sqrt(d.size) / 10 || 4.5; });

            // Add text inside the circles
            nodeEnter.append("text")
                .attr("dy", ".35em")
                .attr("text-anchor", "middle")
                .style("font-size", "12px")
                .text(function(d) { return d.name; });

            // Add score (size) below the name inside the circle
            nodeEnter.append("text")
                .attr("dy", "1.5em")
                .attr("text-anchor", "middle")
                .style("font-size", "10px")
                .text(function(d) { return `Score: ${d.size}`; });

            node.select("circle")
                .style("fill", color);
        }

        function tick() {
            link.attr("x1", function(d) { return d.source.x; })
                .attr("y1", function(d) { return d.source.y; })
                .attr("x2", function(d) { return d.target.x; })
                .attr("y2", function(d) { return d.target.y; });

            node.attr("transform", function (d) { return "translate(" + d.x + "," + d.y + ")"; });

            node.forEach(function (d) {
                if (d._children || d.children) {
                    d.x = width / 2, d.y = height / 2;
                    d.fixed = true;
                }
            });
        }

        function color(d) {
            return d._children ? "#3182bd" // collapsed package
                : d.children ? "#2F9BC1" // expanded package
                : "#fd8d3c"; // leaf node
        }

        // Toggle children on click.
        function click(obj) {
            if (d3.event.defaultPrevented) return; // ignore drag
            if (obj.children) {
                obj._children = obj.children;
                obj.children = null;
            } else {
                obj.children = obj._children;
                obj._children = null;
            }
            update();
        }

        // Returns a list of all nodes under the root.
        function flatten(root) {
            var nodes = [], i = 0;

            function recurse(node) {
                if (node.children) node.children.forEach(recurse);
                if (!node.id) node.id = ++i;
                nodes.push(node);
            }

            recurse(root);
            return nodes;
        }
    </script>
@endsection

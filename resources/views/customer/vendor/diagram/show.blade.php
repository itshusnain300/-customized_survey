@extends('customer.layouts.app')
@section('main')
    @php
        $vendorId = $submitted_vendor->id;
        $questions = $submitted_vendor->questions;
        $totalWeight = 0;
        $totalScore = 0;

        foreach ($questions as $question) {
            $answer = $question->userAnswer($user->id); // Assuming 'answer' is the relation to the Answer model

            if ($answer) {
                $totalScore += $answer->score;
            }

            if ($question->type == 'multiple_choice') {
                $q_opts = $question->options;
                foreach ($q_opts as $q_opt) {
                    $totalWeight += $q_opt->weight;
                }
            } else {
                $totalWeight += $question->weight;
            }
        }

        // Calculate the percentage only after the loop
        $totalScorePer = $totalWeight > 0 ? ($totalScore / $totalWeight) * 100 : 0;

        // @dd($totalWeight);

    @endphp
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active"> Submitted Vendors</li>
                    <li class="breadcrumb-item active"> Show</li>
                </ol>
            </nav>
        </div>
        <section class="container mt-5">

            <h2 class="text-end mb-4">
                Total Score: {{ number_format($totalScorePer, 2) }}% [{{ $totalWeight }}]
            </h2>

            <h5 class="text-end mb-4">
                @if ($average)
                    {{-- @if ($user->teamUser($user) && $user->teamUser($user)->submittedVendors->isNotEmpty()) --}}
                    Average: {{ $average }}%
                @else
                    Notes: No submissions from your team user yet.
                @endif
            </h5>
            {{-- <h2 class="text-end mb-4">Total Score: {{ $totalScore }}</h2> --}}

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
        $(document).ready(function() {
            // Assuming you have the vendor submission ID available
            var userId = {{ $user->id }}; // Ensure you have the user variable available
            var vendorSubmittionId =
            {{ $vendor_submittion->id }}; // Ensure you have the vendor submission variable available

            var url =
                "{{ route('customer.graph.data', ['user' => ':user', 'vendor_submittion' => ':vendor_submittion']) }}";
            url = url.replace(':user', userId).replace(':vendor_submittion', vendorSubmittionId);

            console.log("AJAX Request URL:", url);

            $.ajax({
                url: "{{ route('customer.graph.data', ['user' => 'userId', 'vendor_submittion' => 'vendorSubmittionId']) }}"
                    .replace('userId', userId).replace('vendorSubmittionId', vendorSubmittionId),
                method: 'GET',
                // dataType: 'json',
                success: function(data) {
                    console.log(data);
                    renderDiagram(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error); // Handle any errors
                }
            });

            function renderDiagram(jsonData) {
                console.log("Rendering diagram with data:", jsonData);

                var vendorId = {{ $vendorId }};
                var width = 960,
                    height = 600,
                    root;

                // Create a root node for the vendor
                root = {
                    name: jsonData.name,
                    score: jsonData.score,
                    size: jsonData.size,
                    children: jsonData.children.map(function(child) {
                        return {
                            name: child.category,
                            score: child.score,
                            size: 300000 // Scale size for visualization
                        };
                    })
                };

                var force = d3.layout.force()
                    .linkDistance(200)
                    .charge(-500) // Increased charge for more stability
                    .gravity(0.1) // Slight gravity to keep nodes centered
                    .size([width, height])
                    .on("tick", tick);

                var svg = d3.select("svg")
                    .attr("width", width)
                    .attr("height", height);

                var link = svg.selectAll(".link"),
                    node = svg.selectAll(".node");

                // Start the visualization with the root node
                update();

                function update() {
                    var nodes = flatten(root),
                        links = d3.layout.tree().links(nodes);

                    // Restart the force layout.
                    force
                        .nodes(nodes)
                        .links(links)
                        .start();

                    // Set initial positions to the center of the screen
                    nodes.forEach(function(d) {
                        d.x = width / 2;
                        d.y = height / 2;
                    });

                    // Update links.
                    link = link.data(links, function(d) {
                        return d.target.id;
                    });

                    link.exit().remove();

                    link.enter().insert("line", ".node")
                        .attr("class", "link");

                    // Update nodes.
                    node = node.data(nodes, function(d) {
                        return d.id;
                    });

                    node.exit().remove();

                    var nodeEnter = node.enter().append("g")
                        .attr("class", "node")
                        .on("click", click)
                        .call(force.drag);

                    // Add a circle for the vendor node
                    nodeEnter.append("circle")
                        .attr("r", function(d) {
                            return Math.sqrt(d.size) / 10 || 4.5;
                        });

                    // Add vendor name and score
                    nodeEnter.append("text")
                        .attr("dy", ".35em")
                        .attr("text-anchor", "middle") // Center the text
                        .style("font-size", "12px")
                        .text(function(d) {
                            return d.name;
                        });

                    // Add score (size) below the name inside the circle
                    nodeEnter.append("text")
                        .attr("dy", "1.5em")
                        .attr("text-anchor", "middle") // Center the text
                        .style("font-size", "10px")
                        .text(function(d) {
                            return `Score: ${d.score}`;
                        });

                    node.select("circle")
                        .style("fill", color);
                }

                function tick() {
                    link.attr("x1", function(d) {
                            return d.source.x;
                        })
                        .attr("y1", function(d) {
                            return d.source.y;
                        })
                        .attr("x2", function(d) {
                            return d.target.x;
                        })
                        .attr("y2", function(d) {
                            return d.target.y;
                        });

                    node.attr("transform", function(d) {
                        return "translate(" + d.x + "," + d.y + ")";
                    });

                    // Center nodes more effectively
                    node.forEach(function(d) {
                        if (d._children || d.children) {
                            d.x = width / 2;
                            d.y = height / 2;
                            d.fixed = true; // Fix the position for parent nodes
                        }
                    });
                }

                function color(d) {
                    return d._children ? "#3182bd" // collapsed package
                        :
                        d.children ? "#2F9BC1" // expanded package
                        :
                        "#fd8d3c"; // leaf node
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
                    var nodes = [],
                        i = 0;

                    function recurse(node) {
                        if (node.children) node.children.forEach(recurse);
                        if (!node.id) node.id = ++i;
                        nodes.push(node);
                    }

                    recurse(root);
                    return nodes;
                }
            }

        });
    </script>
@endsection

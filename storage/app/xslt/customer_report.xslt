<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-public="XSLT-compat" indent="yes"/>
    <xsl:param name="sortField" select="'created_at'" />

    <xsl:template match="/">
        <html>
        <head>
            <title>Customer Report</title>
            <style>
                h1, h2 {
                    text-align: center;
                    color: #4CAF50;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: left;
                }
                th {
                    background-color: #4CAF50;
                    color: white;
                    cursor: pointer;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
                .status-active {
                    background-color: #dff0d8;
                }
                .status-suspended {
                    background-color: #f2dede;
                }
                .summary {
                    font-size: 18px;
                    margin-bottom: 20px;
                }
            </style>
            <script>
                function sortTable(sortField) {
                    window.location.href = '?sortField=' + sortField;
                }
            </script>
        </head>
        <body>
            <div class="summary">
                Total Customers: <xsl:value-of select="count(//customer)" /><br/>
                Total Spending: $<xsl:value-of select="sum(//order/total_spent)" />
            </div>

            <h2>Customer Spending by Date</h2>
            <svg width="800" height="400" xmlns="http://www.w3.org/2000/svg">
                <text x="400" y="390" text-anchor="middle" font-size="14">Order Date</text>
                <text x="20" y="200" text-anchor="middle" transform="rotate(-90 20,200)" font-size="14">Spending ($)</text>
                
                <line x1="50" y1="350" x2="750" y2="350" style="stroke:black;stroke-width:1" />
                <line x1="50" y1="50" x2="50" y2="350" style="stroke:black;stroke-width:1" />

                <xsl:for-each select="customers/customer/order">
                    <xsl:sort select="created_at" data-type="text" order="ascending"/>

                    <xsl:variable name="barHeight" select="total_spent div 10"/>
                    <rect x="{position() * 60 + 80}" y="{350 - $barHeight}" width="40" height="{$barHeight}" style="fill:blue;">
                        <title>
                            <xsl:value-of select="created_at"/>: $<xsl:value-of select="total_spent"/>
                        </title>
                    </rect>
                    
                    <text x="{position() * 60 + 100}" y="360" text-anchor="middle" font-size="12" transform="rotate(45 {position() * 60 + 100}, 360)">
                        <xsl:value-of select="substring(created_at, 1, 10)"/>
                    </text>
                </xsl:for-each>
            </svg>

            <table>
                <tr>
                    <th onclick="sortTable('id')">ID</th>
                    <th onclick="sortTable('username')">Username</th>
                    <th onclick="sortTable('email')">Email</th>
                    <th onclick="sortTable('tier')">Tier</th>
                    <th onclick="sortTable('status')">Status</th>
                    <th onclick="sortTable('total_spent')">Total Spent ($)</th>
                    <th onclick="sortTable('created_at')">Order Date</th>
                </tr>
                
                <xsl:for-each select="//customer/order">
                    <xsl:sort select="created_at" data-type="text" order="ascending"/>
                    <tr>
                        <td><xsl:value-of select="../id"/></td>
                        <td><xsl:value-of select="../username"/></td>
                        <td><xsl:value-of select="../email"/></td>
                        <td><xsl:value-of select="../tier"/></td>
                        <td><xsl:value-of select="../status"/></td>
                        <td><xsl:value-of select="total_spent"/></td>
                        <td><xsl:value-of select="created_at"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>

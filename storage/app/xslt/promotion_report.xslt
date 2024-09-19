<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
                <xsl:for-each select="PromotionReports/Promotion">
                    <table>
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td><xsl:value-of select="ID"/></td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td><xsl:value-of select="Title"/></td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td><xsl:value-of select="StartDate"/></td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td><xsl:value-of select="EndDate"/></td>
                            </tr>
                            <tr>
                                <td>Total Revenue</td>
                                <td><xsl:value-of select="RevenueDetails/TotalRevenue"/></td>
                            </tr>
                            <tr>
                                <td>Products Sold</td>
                                <td><xsl:value-of select="ProductsSold"/></td>
                            </tr>
                            <tr>
                                <td>Avg. Order Value (With Promotion)</td>
                                <td><xsl:value-of select="RevenueDetails/AverageOrderValueWith"/></td>
                            </tr>
                            <tr>
                                <td>Avg. Order Value (Without Promotion)</td>
                                <td><xsl:value-of select="RevenueDetails/AverageOrderValueWithout"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="MonthlyRevenue/Month">
                                <tr>
                                    <td><xsl:value-of select="MonthName"/></td>
                                    <td><xsl:value-of select="Revenue"/></td>
                                </tr>
                            </xsl:for-each>
                        </tbody>
                    </table>
                </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
